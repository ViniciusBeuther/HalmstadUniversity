package FinalProject_Tetris.Model;

public class Piece{
    private int[][] shape;
    private int row;
    private int col;

    public Piece(int[][] shape){
        this.shape = shape;
        this.row = 0;
        this.col = 4;
    }

    public int[][] getShape() {
        return shape;
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

    public void movePieceDown(){
        this.setRow(this.getRow() + 1);
    }

    public void movePieceLeft(){
        this.setCol(this.getCol() - 1);
    }

    public void movePieceRight(){
        this.setCol(this.getCol() + 1);
    }
}