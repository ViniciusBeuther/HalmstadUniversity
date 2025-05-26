package FinalProject_Tetris.Model;

import java.awt.*;
import java.util.Random;

/**
 * Piece factory is where the pieces are randomly generated and set its colors,
 * it creates a random piece shape that will be instantiated as Piece.
 *
 * It stores a set of shapes and colors.
 * */
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

    // Gets a random piece
    public Piece createRandomPiece(){
        System.out.println("Log (Piece Factory): Creating random Piece.");
        int[][] shape = SHAPES[this.random.nextInt(SHAPES.length)];
        Color color = getRandomColor();

        return new Piece(shape, color);
    }

    // Gets a random color
    private Color getRandomColor(){
        System.out.println("Log (Piece Factory): getting Piece color.");
        Color[] colors = {
                Color.RED, Color.GREEN, Color.YELLOW,
                Color.CYAN, Color.MAGENTA, Color.ORANGE, Color.PINK
        };

        return colors[random.nextInt(colors.length)];
    }
}