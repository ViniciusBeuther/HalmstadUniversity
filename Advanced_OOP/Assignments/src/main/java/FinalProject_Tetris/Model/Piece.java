package FinalProject_Tetris.Model;

import java.awt.*;

import FinalProject_Tetris.Misc.SoundUtils;

/**
 * Class responsible for the piece handling, move the piece over the board, define the position, color and shape.
 * Is also responsible to rotate the piece and check for collisions. Includes getters and setters.
 * */
public class Piece{
    private int[][] shape;
    private int row;
    private int col;
    private Color color;

    /** constructor, initialize the class attributes
     * @param shape: random shape created by PieceFactory
     * @param color: random color created by PieceFactory
     * */
    public Piece(int[][] shape, Color pieceColor){
        this.shape = shape;
        this.row = 0;
        this.col = 4;
        this.color = pieceColor;
    }

    public int[][] getShape() {
        return shape;
    }

    public Color getColor(){
        return this.color;
    }

    public int getRow() {
        return row;
    }

    public int getCol() {
        return col;
    }

    public void movePieceDown(Cell[][] board){
        if(canMoveTo(row + 1, col, board)) row++;
    }

    public void movePieceLeft(Cell[][] board){
        if(canMoveTo(row, col - 1, board)) {
        System.out.println("Log (Piece): Moved piece left.");
            col--;
            SoundUtils.playSound("/lateral_movement.wav");
        };
    }

    public void movePieceRight(Cell[][] board){
        if(canMoveTo(row, col + 1, board)) {
            System.out.println("Log (Piece): Moved piece right.");
            col++;
            SoundUtils.playSound("/lateral_movement.wav");
        };
    }

    // Method that rotates the piece
    public void rotatePiece(Cell[][] board){
        if(canRotate(board)) {
            System.out.println("Log (Piece): Piece rotated.");
            int rows = shape.length;
            int cols = shape[0].length;
            int[][] rotated = new int[cols][rows];

            for (int i = 0; i < rows; i++) {
                for (int j = 0; j < cols; j++) {
                    rotated[j][rows - 1 - i] = shape[i][j];
                }
            }
            this.shape = rotated;
            SoundUtils.playSound("/rotate.wav");
        }
    }

    // Method that checks if it is possible to rotate the piece, check if it is not too close to the edges
    // to avoid bugs
    public boolean canRotate(Cell[][] board){
        System.out.println("Log (Piece): verify if piece can rotate.");
        int rows = shape.length;
        int cols = shape[0].length;
        int[][] rotatedShape = new int[cols][rows];

        // Create the rotated shape
        for (int i = 0; i < rows; i++) {
            for (int j = 0; j < cols; j++) {
                rotatedShape[j][rows - 1 - i] = shape[i][j];
            }
        }

        // Check if the rotated shape can fit at current position
        return canShapeFitAt(rotatedShape, row, col, board);
    }

    // Check if the shape can be moved to a position
    private boolean canShapeFitAt(int[][] shapeToCheck, int checkRow, int checkCol, Cell[][] board){
        for(int i = 0; i < shapeToCheck.length; i++){
            for(int j = 0; j < shapeToCheck[i].length; j++){
                if(shapeToCheck[i][j] != 0){
                    int boardRow = checkRow + i;
                    int boardCol = checkCol + j;

                    // Check row limits (vertical)
                    if(boardRow >= board.length || boardRow < 0) return false;

                    // Check horizontal limits
                    if(boardCol < 0 || boardCol >= board[0].length) return false;

                    // Check collision with other piece
                    if(board[boardRow][boardCol].isFilled()) return false;
                }
            }
        }
        return true;
    }

    // Verify if the there is collision with other pieces, edges or bottom
    public boolean hasCollision(Cell[][] board, int nextRow, int nextColumn){
        int[][] shape = this.getShape();

        for (int i = 0; i < shape.length; i++) {
            for (int j = 0; j < shape[i].length; j++) {
                if (shape[i][j] != 0) {
                    int boardRow = nextRow + i;
                    int boardCol = nextColumn + j;

                    // check collision with border
                    if (boardRow >= board.length || boardCol < 0 || boardCol >= board[0].length) {
                        System.out.println("Log (Piece): Border collision.");
                        return true;
                    }

                    // Check collision with other fixed pieces
                    if (boardRow >= 0 && board[boardRow][boardCol] != null && board[boardRow][boardCol].isFilled()) {
                        System.out.println("Log (Piece): Fixed pieces collision.");
                        return true;
                    }
                }
            }
        }

        return false;
    }

    // Check if we can move to a position, used in movement
    public boolean canMoveTo(int newRow, int newCol, Cell[][] board){
        int[][] shape = this.getShape();
        System.out.println("Log (Piece): verify if piece can move to a position.");
        for(int i = 0; i < shape.length; i++){
            for(int j = 0; j < shape[i].length; j++){
                if(shape[i][j] != 0){
                    int boardRow = newRow + i;
                    int boardCol = newCol + j;

                    // check row limits (vertical)
                    if(boardRow >= board.length || boardRow < 0) return false;

                    // check horizontal limits
                    if(boardCol < 0 || boardCol >= board[0].length) return false;

                    // check collision with other piece
                    if(board[boardRow][boardCol].isFilled()) return false;
                }
            }
        }

        return true;
    }

    // Fix the piece in the board.
    public void fixPieceInBoard(Piece piece, Cell[][] board){
        int[][] shape = piece.getShape();
        int row = piece.getRow();
        int col = piece.getCol();
        System.out.println("Log (Piece): Fixing piece on the board.");
        for(int i=0; i < shape.length; i++){
            for(int j=0; j < shape[i].length; j++){
                if(shape[i][j] != 0){
                    int boardRow = row + i;
                    int boardCol = col + j;
                    Color cellColor = piece.getColor();

                    board[boardRow][boardCol].setFilled(true);
                    board[boardRow][boardCol].setColor(cellColor);

                }
            }
        }
    }

}