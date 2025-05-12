package FinalProject_Tetris.Controller;

import FinalProject_Tetris.Model.Piece;
import FinalProject_Tetris.View.TetrisView;

import java.awt.event.KeyAdapter;
import java.awt.event.KeyEvent;

public class TetrisController{
    private TetrisView tetrisView;

    public TetrisController(TetrisView tetrisView){
        this.tetrisView = tetrisView;
        observeKeyPressed();
    }

    public void observeKeyPressed(){
        tetrisView.addKeyListener(new KeyAdapter() {

            @Override
            public void keyPressed(KeyEvent e){
                Piece piece = tetrisView.getCurrentPiece();

                switch (e.getKeyCode()){
                    case KeyEvent.VK_LEFT -> piece.movePieceLeft(tetrisView.getBoard());
                    case KeyEvent.VK_RIGHT -> piece.movePieceRight(tetrisView.getBoard());
                    case KeyEvent.VK_DOWN -> piece.movePieceDown(tetrisView.getBoard());
                    case KeyEvent.VK_UP -> piece.rotatePiece();
                }

                tetrisView.repaint();
            }
        });
    }
}