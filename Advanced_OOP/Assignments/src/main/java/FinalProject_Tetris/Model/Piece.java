package FinalProject_Tetris.Model;

import java.awt.*;

public class Piece{
    private int[][] shape;
    private int row;
    private int col;
    private Color color;

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

    public void setRow(int i){
        this.row = i;
    }

    public int getCol() {
        return col;
    }

    public void setCol(int i){
        this.col = i;
    }

    public void movePieceDown(Cell[][] board){
        if(canMoveTo(row + 1, col, board)) row++;
    }

    public void movePieceLeft(Cell[][] board){
        if(canMoveTo(row, col - 1, board)) col--;
    }

    public void movePieceRight(Cell[][] board){
        if(canMoveTo(row, col + 1, board)) col++;
    }

    public void rotatePiece(){
        int rows = shape.length;
        int cols = shape[0].length;
        int[][] rotated = new int[cols][rows];

        for (int i = 0; i < rows; i++) {
            for (int j = 0; j < cols; j++) {
                rotated[j][rows - 1 - i] = shape[i][j];
            }
        }

        this.shape = rotated;
    }

    public boolean hasCollision(Cell[][] board, int nextRow, int nextColumn){
        int[][] shape = this.getShape();

        for (int i = 0; i < shape.length; i++) {
            for (int j = 0; j < shape[i].length; j++) {
                if (shape[i][j] != 0) {
                    int boardRow = nextRow + i;
                    int boardCol = nextColumn + j;

                    // check collision with border
                    if (boardRow >= board.length || boardCol < 0 || boardCol >= board[0].length) {
                        return true;
                    }

                    // Check collision with other fixed pieces
                    if (boardRow >= 0 && board[boardRow][boardCol] != null && board[boardRow][boardCol].isFilled()) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public boolean canMoveTo(int newRow, int newCol, Cell[][] board){
        int[][] shape = this.getShape();

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

    public void fixPieceInBoard(Piece piece, Cell[][] board){
        int[][] shape = piece.getShape();
        int row = piece.getRow();
        int col = piece.getCol();

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