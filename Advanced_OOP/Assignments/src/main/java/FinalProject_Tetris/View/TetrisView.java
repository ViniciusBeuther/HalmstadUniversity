package FinalProject_Tetris.View;

import FinalProject_Tetris.Model.Piece;

import javax.swing.*;
import java.awt.*;

public class TetrisView extends JPanel{
    public static final int WIDTH = 1280;
    public static final int HEIGHT = 720;
    public static final int cellSize = 30;
    private static final int OFFSET_X = (WIDTH - (10 * cellSize)) / 2;
    private static final int OFFSET_Y = (HEIGHT - (20 * cellSize)) / 2;

    private int[][] board = new int[20][10];
    private Piece currentPiece;

    public TetrisView(){
        this.setPreferredSize(new Dimension(WIDTH, HEIGHT));
        this.setBackground(new Color(0, 0,0));
        this.setLayout(null);
        this.printBoard();
    }

    public int[][] getBoard(){
        return this.board;
    }

    public void printBoard(){
        for(int i = 0; i < board.length; i++) {
            for (int j = 0; j < board[i].length; j++) {
                System.out.print((board[i][j] == 0 ? ". " : "# ")); // board cell
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

        g2d.setColor(Color.ORANGE);

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

                    g2d.setColor(Color.orange);
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

                if (board[row][col] == 0) {
                    g2d.setColor(Color.LIGHT_GRAY); // célula vazia
                    g2d.drawRect(x, y, cellSize, cellSize); // apenas borda
                } else {
                    g2d.setColor(Color.BLUE); // célula preenchida
                    g2d.fillRect(x, y, cellSize, cellSize);
                    g2d.setColor(Color.BLACK); // borda
                    g2d.drawRect(x, y, cellSize, cellSize);
                }
            }
        }
    }

}