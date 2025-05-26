package FinalProject_Tetris;

import FinalProject_Tetris.View.GameWindow;
import javax.swing.*;

class TetrisGame{
    /**
     * Main class, its our entry point where we create the game and start it.
     * */
    public static void main(String[] args){
        SwingUtilities.invokeLater(() -> {
            GameWindow game = new GameWindow();
            game.start();
    });
}

}