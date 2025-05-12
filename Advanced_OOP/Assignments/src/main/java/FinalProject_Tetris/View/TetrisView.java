package FinalProject_Tetris.View;

import FinalProject_Tetris.Model.Cell;
import FinalProject_Tetris.Model.Piece;

import javax.swing.*;
import java.awt.*;

public class TetrisView extends JPanel{
    public static final int WIDTH = 1280;
    public static final int HEIGHT = 720;
    public static final int cellSize = 30;
    private static final int OFFSET_X = (WIDTH - (10 * cellSize)) / 2;
    private static final int OFFSET_Y = (HEIGHT - (20 * cellSize)) / 2;

    private Cell[][] board = new Cell[20][10];
    private Piece currentPiece;

    public TetrisView(){
        /** Initialize with empty cells */
        for(int i=0; i < board.length; i++){
            for(int j=0; j < board[i].length; j++){
                board[i][j] = new Cell(false, Color.black);
            }
        }

        this.setPreferredSize(new Dimension(WIDTH, HEIGHT));
        this.setBackground(new Color(204, 255,255));
        this.setLayout(null);
        this.printBoard();
    }

    public Cell[][] getBoard(){
        return this.board;
    }

    public void printBoard(){
        for(int i = 0; i < board.length; i++) {
            for (int j = 0; j < board[i].length; j++) {
                System.out.print((board[i][j] == null || !board[i][j].isFilled() ? ". " : "# ")); // board cell
            }
            System.out.println();
        }
        System.out.println("=".repeat(board[0].length * 2)); // separator
    }

    public void setCurrentPiece(Piece currentPiece) {
        this.currentPiece = currentPiece;
        repaint();
    }

    public Piece getCurrentPiece() {
        return currentPiece;
    }

    @Override
    protected void paintComponent(Graphics g){
        super.paintComponent(g);
        this.drawBoard(g);
        this.drawPiece(g);
    }

    public void drawPiece(Graphics g){
        if(this.currentPiece == null) return;

        Graphics2D g2d = (Graphics2D) g;

        int[][] shape = this.getCurrentPiece().getShape();
        int row = this.getCurrentPiece().getRow();
        int column = this.getCurrentPiece().getCol();

        g2d.setColor(this.currentPiece.getColor());

        for(int i=0; i < shape.length; i++){
            for(int j=0; j < shape[i].length; j++){
                if(shape[i][j] != 0){
                    // get relative position
                    int x = OFFSET_X + (column + j) * cellSize;
                    int y = OFFSET_Y + (row + i) * cellSize;

                    // add border and repaint
                    g2d.fillRect(x, y, cellSize, cellSize);
                    g2d.setColor(Color.BLACK);
                    g2d.drawRect(x, y, cellSize, cellSize);

                    g2d.setColor(this.currentPiece.getColor());
                }
            }
        }
    }

    /** draw board */
    public void drawBoard(Graphics g) {
        Graphics2D g2d = (Graphics2D) g;
        int cellSize = 30;

        for (int row = 0; row < board.length; row++) {
            for (int col = 0; col < board[row].length; col++) {
                int x = OFFSET_X + col * cellSize;
                int y = OFFSET_Y + row * cellSize;

                if (!board[row][col].isFilled()) {
                    g2d.setColor(Color.LIGHT_GRAY);
                    g2d.drawRect(x, y, cellSize, cellSize);
                } else {
                    g2d.setColor(board[row][col].getColor());
                    g2d.fillRect(x, y, cellSize, cellSize);
                    g2d.setColor(Color.BLACK);
                    g2d.drawRect(x, y, cellSize, cellSize);
                }
            }
        }
    }

    public void canCleanLines(){
        Cell board[][] = getBoard();
        int rows = board.length;
        int columns = board[0].length;

        for(int i = rows - 1; i >= 0; i--){
            boolean isFullLine = true;

            for(int j=0; j < columns; j++){
                if(board[i][j] == null || !board[i][j].isFilled()){
                    isFullLine = false;
                    break;
                }
            }

            /** if the line is full, moving the row above one line down */
            if(isFullLine){
                for(int k=i; k > 0; k--){
                    board[k] = board[k - 1].clone();
                }

                /** creates a new empty line above */
                board[0] = new Cell[columns];
                for(int j=0; j < columns; j++){
                    board[0][j] = new Cell(false, Color.black);
                }

                i++;
            }
        }
    }
}