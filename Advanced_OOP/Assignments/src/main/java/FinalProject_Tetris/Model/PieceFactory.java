package FinalProject_Tetris.Model;

import java.util.Random;

public class PieceFactory{
    private static final int[][][] SHAPES = {
            {{1, 1, 1, 1}},                 // I
            {{1, 1}, {1, 1}},               // O
            {{0, 1, 0}, {1, 1, 1}},         // T
            {{1, 1, 0}, {0, 1, 1}},         // S
            {{0, 1, 1}, {1, 1, 0}},         // Z
            {{1, 0, 0}, {1, 1, 1}},         // J
            {{0, 0, 1}, {1, 1, 1}}          // L
    };

    private Random random = new Random();

    public Piece createRandomPiece(){
        int[][] shape = SHAPES[this.random.nextInt(SHAPES.length)];

        return new Piece(shape);
    }
}