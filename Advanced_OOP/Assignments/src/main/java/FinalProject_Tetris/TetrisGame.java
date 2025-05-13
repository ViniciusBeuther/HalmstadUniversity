package FinalProject_Tetris;

import FinalProject_Tetris.View.GameWindow;
import javax.swing.*;

class TetrisGame{
    public static void main(String[] args){
        SwingUtilities.invokeLater(() -> {
            GameWindow game = new GameWindow();
            game.start();
    });
}

}