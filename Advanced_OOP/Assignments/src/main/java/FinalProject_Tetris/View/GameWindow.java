package FinalProject_Tetris.View;

import FinalProject_Tetris.Controller.TetrisController;
import FinalProject_Tetris.Misc.SoundUtils;
import FinalProject_Tetris.Model.Cell;
import FinalProject_Tetris.Model.Piece;
import FinalProject_Tetris.Model.PieceFactory;

import javax.swing.*;
import java.awt.*;
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;


/**
 * This class takes care of the game loop, where we have attributes to save the level,
 * number of rows cleaned and an initial delay, which will be increased over the time/level ups.
 *
 * We also have the getters/setters
 * */
public class GameWindow {
    private int[] level;
    private int[] numberOfRowsCleaned;
    private int initialDelay;
    Timer[] gameTimer = new Timer[1];

    // Constructor, initialize the level/delay and number of rows cleaned
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
     * @param view: the TetrisView component, where it stores the board and window specifications (board)
     * @param side: is the Side bar containing extra info such as levels, next piece and leaderboard.
     *
     * It also start the game window.
     * */
    public void initializeWindow(TetrisView view, SidePanel side){
        System.out.println("Log (GameWindow): Building game window.");
        JFrame window = new JFrame();
        JPanel mainPanel = new JPanel(new BorderLayout());
        mainPanel.add(view, BorderLayout.CENTER);
        mainPanel.add(side, BorderLayout.WEST);
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
        System.out.println("Log (Game Window): starting game...");
        // using arrays to avoid issue in timer loop
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

        /* Game loop, also verify the collisions,
        * it finishes the game if the user lost, handle the score saving
        *  and the timer loop, move the piece down every X seconds
        **/
        System.out.println("Log (Game Window): Starting timer(loop).");
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
                    SoundUtils.playSound("/game_over.wav");
                    // JOptionPane.showMessageDialog(null, "Game over!");
                    System.out.println("Log (Game Window): Game over, getting username.");

                    String username = JOptionPane.showInputDialog(null, "Game over!\nPut your name here if you want to save your score:", "Input Dialog", JOptionPane.PLAIN_MESSAGE);

                    if (username != "") {
                        try (BufferedWriter writer = new BufferedWriter(new FileWriter("scores.txt", true))) {
                            writer.write(username + ": " + numberOfRowsCleaned[0] + "\n");
                            System.out.println("Log (Game Window): Username saved on score.txt.");

                        } catch (IOException er) {
                            System.err.println("An error occurred while writing to the file: " + er.getMessage());
                        }
                    } else {
                        System.out.println("User doesn't want to save the score.");
                    }



                    // Player's score
                    System.out.println("Log (Game Window): Show player score.");
                    JOptionPane.showMessageDialog(null, "Your score is: " + numberOfRowsCleaned[0]);

                    
                    // Print out the top n scores saved in the leaderboard
                    int n = 3;
                    
                    Map<String, Integer> scores = new HashMap<>();
                    BufferedReader reader = null;
					try {
						reader = new BufferedReader(new FileReader("scores.txt"));
					} catch (FileNotFoundException e1) {
						// TODO Auto-generated catch block
						e1.printStackTrace();
					}
                    String line;
                    
                    try {
						while ((line = reader.readLine()) != null) {
						    String[] fields = line.split(":");
						    String name = fields[0].trim();
						    int score = Integer.parseInt(fields[1].trim());
							if (!scores.containsKey(name) || score > scores.get(name)) {
								scores.put(name, score);
							}

						}
					} catch (NumberFormatException e1) {
						// TODO Auto-generated catch block
						e1.printStackTrace();
					} catch (IOException e1) {
						// TODO Auto-generated catch block
						e1.printStackTrace();
					}
                    try {
						reader.close();
					} catch (IOException e1) {
						// TODO Auto-generated catch block
						e1.printStackTrace();
					}

                    StringBuilder ranking = new StringBuilder("🏆 Top " + n + " Scores 🏆\n\n");
                    for (int i = 1; i <= n && !scores.isEmpty(); i++) {
                        String maxName = null;
                        int maxValue = Integer.MIN_VALUE;
                        for (String name : scores.keySet()) {
                        	int value = scores.get(name);
                            if (maxName == null || value > maxValue) {
                                maxName = name;
                                maxValue = value;
                            }
                        }
                        ranking.append(String.format("%d. %s - %d\n", i, maxName, maxValue));
                        scores.remove(maxName);
                    }
                    

                    // Show ranking
                    JOptionPane.showMessageDialog(null, ranking.toString(), "Leaderboard", JOptionPane.INFORMATION_MESSAGE);
                    
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
