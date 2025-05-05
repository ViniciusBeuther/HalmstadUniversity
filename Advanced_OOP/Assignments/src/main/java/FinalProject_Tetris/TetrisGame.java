package FinalProject_Tetris;

import FinalProject_Tetris.Model.Piece;
import FinalProject_Tetris.Model.PieceFactory;
import FinalProject_Tetris.View.TetrisView;

import javax.swing.*;

class TetrisGame{
    public static void main(String[] args){
        SwingUtilities.invokeLater(() -> {

            JFrame tetrisWindow = new JFrame("Tetris Game");
            tetrisWindow.setDefaultCloseOperation(WindowConstants.EXIT_ON_CLOSE);
            tetrisWindow.setResizable(false);

            PieceFactory factory = new PieceFactory();
            Piece randomPiece = factory.createRandomPiece();

            TetrisView tetrisView = new TetrisView();
            tetrisView.setCurrentPiece(randomPiece);

            tetrisWindow.add(tetrisView);
            tetrisWindow.pack();
            tetrisWindow.setLocationRelativeTo(null);
            tetrisWindow.setVisible(true);

            Timer timer = new Timer(200, e-> {
                tetrisView.getCurrentPiece().movePieceDown();
                tetrisView.repaint();
            });

            timer.start();
        });

    }
}