package FinalProject_Tetris.Model;

import java.awt.*;

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
