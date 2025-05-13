package FinalProject_Tetris.View;

import FinalProject_Tetris.Controller.TetrisController;
import FinalProject_Tetris.Model.Cell;
import FinalProject_Tetris.Model.Piece;
import FinalProject_Tetris.Model.PieceFactory;

import javax.swing.*;
import java.awt.*;

public class GameWindow {
    private int[] level;
    private int[] numberOfRowsCleaned;
    private int initialDelay;
    Timer[] gameTimer = new Timer[1];

    public GameWindow(){
        setLevel(new int[]{1});
        setNumberOfRowsCleaned(new int[] {0});
        setInitialDelay(800);

    }

    public void setLevel(int[] level) {
        this.level = level;
    }

    public void setNumberOfRowsCleaned(int[] numberOfRowsCleaned) {
        this.numberOfRowsCleaned = numberOfRowsCleaned;
    }

    public void setInitialDelay(int delay){
        this.initialDelay = delay;
    }

    /**
     * Start the window
     * @param view: the TetrisView component, where it stores the board and window specifications
     * */
    public void initializeWindow(TetrisView view, SidePanel side){
        JFrame window = new JFrame();
        JPanel mainPanel = new JPanel(new BorderLayout());
        mainPanel.add(view, BorderLayout.CENTER);
        mainPanel.add(side, BorderLayout.EAST);
        window.setDefaultCloseOperation(WindowConstants.EXIT_ON_CLOSE);
        window.setResizable(false);
        window.add(mainPanel);
        window.pack();
        window.setLocationRelativeTo(null);
        window.setVisible(true);
    }

    /**
     *            initialize the game window and handle all the logic for incrementing the level over time
     *            based on how many lines were cleaned. It also verifies the collision with other pieces/board
     **/
    public void start() {
        PieceFactory factory = new PieceFactory();

        // Use arrays para contornar a restrição
        final Piece[] currentPieceHolder = {factory.createRandomPiece()};
        final Piece[] nextPieceHolder = {factory.createRandomPiece()};

        TetrisView tetrisView = new TetrisView();
        SidePanel sidePanel = new SidePanel();

        sidePanel.setNextPiece(nextPieceHolder[0].getShape(), nextPieceHolder[0].getColor());
        sidePanel.setLevel(level[0]);

        initializeWindow(tetrisView, sidePanel);

        tetrisView.setCurrentPiece(currentPieceHolder[0]);
        tetrisView.setFocusable(true);
        tetrisView.requestFocusInWindow();
        TetrisController tc = new TetrisController(tetrisView);

        /* Game loop */
        gameTimer[0] = new Timer(initialDelay, e-> {
            Piece current = tetrisView.getCurrentPiece();
            Cell[][] board = tetrisView.getBoard();

            if(!current.hasCollision(board, current.getRow() + 1, current.getCol())){
                current.movePieceDown(board);
            } else {
                current.fixPieceInBoard(current, board);
                int lines = tetrisView.canCleanLines();
                numberOfRowsCleaned[0] += lines;

                if(nextPieceHolder[0].hasCollision(board, nextPieceHolder[0].getRow(), nextPieceHolder[0].getCol())){
                    ((Timer) e.getSource()).stop();
                    JOptionPane.showMessageDialog(null, "Game over!");
                    System.exit(0);
                } else {
                    tetrisView.setCurrentPiece(nextPieceHolder[0]);
                    currentPieceHolder[0] = nextPieceHolder[0];
                    nextPieceHolder[0] = factory.createRandomPiece();
                    sidePanel.setNextPiece(nextPieceHolder[0].getShape(), nextPieceHolder[0].getColor());
                    sidePanel.setLevel(level[0]);
                }

                if(numberOfRowsCleaned[0] >= level[0] * 5 && gameTimer[0].getDelay() >= 50){
                    level[0]++;
                    int newDelay = gameTimer[0].getDelay() - 50;
                    gameTimer[0].setDelay(newDelay);
                    System.out.println("Level " + level[0] + " - Speed: " + newDelay + " ms.");
                }
            }
            tetrisView.repaint();
        });

        gameTimer[0].start();
    }

}
