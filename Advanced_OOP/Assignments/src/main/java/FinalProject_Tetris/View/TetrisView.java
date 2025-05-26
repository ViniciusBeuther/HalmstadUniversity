package FinalProject_Tetris.View;

import FinalProject_Tetris.Model.Cell;
import FinalProject_Tetris.Model.Piece;

import javax.swing.*;
import java.awt.*;

/**
 * This class is responsible to be the board, where all the pieces are placed,
 * we have some window properties as well such as WIDTH and HEIGHT, the OFFSETs
 * are used to centralize correctly the elements.
 *
 * This class also have getters and setters for some attributes.
 *
 *
 * currentPiece = the piece that is being dropped
 * board = matrix[][] of Cell elements.
 * */
public class TetrisView extends JPanel{
    public static final int WIDTH = 480; //1280
    public static final int HEIGHT = 720; //720
    public static final int cellSize = 30;
    private static final int OFFSET_X = (WIDTH - (10 * cellSize)) / 2;
    private static final int OFFSET_Y = (HEIGHT - (20 * cellSize)) / 2;

    private Cell[][] board = new Cell[20][10];
    private Piece currentPiece;

    /**
     * Constructor, where we initialize the board and define every of its properties.
     * */
    public TetrisView(){
        System.out.println("Log (Tetris View): starting Tetris View class.");
        /* Initialize with empty cells */
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

    /**
     * Function used to print a version of the board in the console,
     * it was used just to understand how the positions and the board works, based on values
     * and how they will be used to handle the game logic.
     * */
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

    // Paint the component, draw the piece and board, override of a method
    @Override
    protected void paintComponent(Graphics g){
        System.out.println("Log (Tetris View): painting component.");
        super.paintComponent(g);
        this.drawBoard(g);
        this.drawPiece(g);
    }

    /**
     * This method is responsible to draw the piece in the board, it sets the shape and define the initial
     * position by getting the row and column, also it uses the offset to centralize.
     * This method paint the piece in the board.
     * */
    public void drawPiece(Graphics g){
        // System.out.println("Log (Tetris View): drawing piece.");
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

    /**
     * This method is responsible to start and draw the board,
     * loop over the matrix and paint the cells
     **/
    public void drawBoard(Graphics g) {
        // System.out.println("Log (Tetris View): drawing board.");

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

    /**
     * This function is responsible to check if is it possible to clean the line,
     * if the line is complete than it removed the full line and move the one at the top
     * one line down.
     *
     * */
    public int canCleanLines(){
        Cell board[][] = getBoard();
        int rows = board.length;
        int columns = board[0].length;
        int linesCleanedCounter = 0;
        System.out.println("Log (Tetris View): Check if can clean lines (if line is full).");


        for(int i = rows - 1; i >= 0; i--){
            boolean isFullLine = true;

            for(int j=0; j < columns; j++){
                if(board[i][j] == null || !board[i][j].isFilled()){
                    isFullLine = false;
                    break;
                }
            }

            // if the line is full, moving the row above one line down.
            if(isFullLine){
                System.out.println("Log (Tetris View): line is full, removing line and shifting.");

                for(int k=i; k > 0; k--){
                    board[k] = board[k - 1].clone();
                }

                // creates a new empty line above
                board[0] = new Cell[columns];
                for(int j=0; j < columns; j++){
                    board[0][j] = new Cell(false, Color.black);
                }

                i++;
                linesCleanedCounter++;
            }
        }

        return linesCleanedCounter;
    }
}