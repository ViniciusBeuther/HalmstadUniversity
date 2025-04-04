package Assignment_01;

public class MatrixInteractive {
    public static void main(String[] args){
//      Matrix Sum
        Matrix m1 = new Matrix(3,3);
        Matrix m2 = new Matrix(3,3);

//  Showing first matrix
        System.out.println("Matrix 1:");
        m1.listElements();

//  Showing second matrix
        System.out.println("Matrix 2:");
        m2.listElements();

//  Calling addition method and showing the result matrix
        System.out.println("\n===Addition Result for Matrixes (m1 + m2) ===");
        Matrix m3 = m1.sumWith(m2);
        m3.listElements();
        System.out.println("\n=======================\n");

//  Initializing matrix 4 and 5 and call the method to initialize them
        Matrix m4 = new Matrix(2,2);
        System.out.println("Matrix 1:");
        m4.listElements();

        Matrix m5 = new Matrix(2,3);
        System.out.println("Matrix 2:");
        m5.listElements();

//  Showing the multiplication result
        Matrix m6 = m4.multiplyBy(m5);
        System.out.println("===Multilication Result Matrix 1 x Matrix 2===");
        m6.listElements();
    }
}