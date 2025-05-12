package FinalProject_Tetris;

import FinalProject_Tetris.Controller.TetrisController;
import FinalProject_Tetris.Model.Cell;
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

            tetrisView.setFocusable(true);
            tetrisView.requestFocusInWindow();
            TetrisController tc = new TetrisController(tetrisView);

            /** Game loop */
            Timer timer = new Timer(200, e-> {
                Piece current = tetrisView.getCurrentPiece();
                Cell[][] board = tetrisView.getBoard();

                /** check if it doesn't hit the bottom border  */
                if(!current.hasCollision(board, current.getRow() + 1, current.getCol())){
                    current.movePieceDown(board);
                } else {
                    /** check if the new piece has space to be created, if not the game ends */
                    current.fixPieceInBoard(current, board);
                    tetrisView.canCleanLines();
                    Piece nextPiece = factory.createRandomPiece();

                    if(nextPiece.hasCollision(board, nextPiece.getRow(), nextPiece.getCol())){
                        ((Timer) e.getSource()).stop();
                        JOptionPane.showMessageDialog(null, "Game over!");
                        System.exit(0);
                    } else {
                        tetrisView.setCurrentPiece(nextPiece);
                    }
                }

                tetrisView.repaint();
            });

            timer.start();
        });

    }
}