package Assignment_01;

public class Matrix {
    private int nRows;
    private int nColumns;
    private final double[][] elements;

//  Constructor, NOTE: We're populating the matrix with random numbers (double).
    public Matrix( int rows, int columns ){
        this.nRows = rows;
        this.nColumns = columns;
        this.elements = new double[rows][columns];

        for(int i=0; i<rows; i++){
            for(int j=0; j<columns; j++){
                int random = (int)(Math.random() * 101);
                this.setMatrix(i,j,random);
            }
        }
    }

    public int getnRows() {
        return nRows;
    }

    public void setnRows(int nRows) {
        this.nRows = nRows;
    }

    public int getnColumns() {
        return nColumns;
    }

    public void setnColumns(int nColumns) {
        this.nColumns = nColumns;
    }

    public double[][] getMatrix() {
        return elements;
    }

    public double getPosition(int row, int column){
        return this.getMatrix()[row][column];
    }

    public void setMatrix(int rowPos, int colPos, double number) {
        this.elements[rowPos][colPos] = number;
    }

//  list all the elements in the matrix in na tabular format
    public void listElements() {
        for (int i = 0; i < this.nRows; i++) {
            for (int j = 0; j < this.nColumns; j++) {
                System.out.printf("%10.1f ", this.getPosition(i, j));
            }

        // Line break to display correctly
        System.out.println();
        }
    }

//  Method to sum two matrices
    public Matrix sumWith( Matrix m2 ){
        if (this.getnColumns() == m2.getnColumns() && this.getnRows() == m2.getnRows()) {
            Matrix resultMatrix = new Matrix(this.getnRows(), this.getnColumns());

            for( int i=0; i<this.getnRows(); i++ ){
                for( int j=0; j<this.getnColumns(); j++ ){
                    resultMatrix.setMatrix(i, j, this.getPosition(i, j) + m2.getPosition(i, j));
                }
            }

            return resultMatrix;
        }
        return null;
    }

//  Method to multiply one matrix by other
    public Matrix multiplyBy(Matrix m2) {
        Matrix resultMatrix = new Matrix(this.getnRows(), m2.getnColumns());

        if (this.getnColumns() == m2.getnRows()) {
            for (int i = 0; i < this.getnRows(); i++) {
                for (int j = 0; j < m2.getnColumns(); j++) {
                    double accumulator = 0;
                    for (int k = 0; k < this.getnColumns(); k++) {
                        accumulator += (this.getPosition(i, k) * m2.getPosition(k, j));
                    }
                    resultMatrix.setMatrix(i, j, accumulator);
                }
            }
        } else {
            throw new IllegalArgumentException("Matrix multiplication is not possible with the matrices provided.");
        }

        return resultMatrix;
    }
}
