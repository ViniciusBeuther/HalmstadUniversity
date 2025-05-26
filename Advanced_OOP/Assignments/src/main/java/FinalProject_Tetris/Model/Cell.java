package FinalProject_Tetris.Model;

import java.awt.*;

/**
 * This class is what build the board, a board is a matrix of Cells (rows/columns)
 * is stores if the cell is filled or not and the color. Contain the getters and setters
 * */
public class Cell {
    private boolean filled;
    private Color color;

    public Cell(boolean filled, Color color){
        this.filled = filled;
        this.color = color;
    }

    public boolean isFilled(){
        return filled;
    }

    public void setFilled(boolean isFilled){
        this.filled = isFilled;
    }

    public Color getColor(){
        return this.color;
    }

    public void setColor(Color newColor){
        this.color = newColor;
    }
}
