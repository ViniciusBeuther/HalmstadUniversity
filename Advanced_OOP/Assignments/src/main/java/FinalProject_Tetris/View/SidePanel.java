package FinalProject_Tetris.View;

import javax.swing.*;
import java.awt.*;
import java.io.File;
import java.io.FileNotFoundException;
import java.util.*;
import java.util.List;

/**
 * This class is responsible to be the side panel, where we have the information about
 * leaderboard, next piece and the level.
 *
 * The attributes here are to represent this information,
 * the nextShape represents the next piece to fall and next color represents
 * the piece color.
 *
 * Getters and setters are also included in this class.
 * */
public class SidePanel extends JPanel {
    private JLabel levelLabel;
    private JPanel nextPiecePanel;
    private int[][] nextShape;
    private Color nextColor;
    protected JTextArea leaderboardArea;

    /**
     * Constructor method, it sets the panel dimensions and colors,
     * it also responsible for insert the Level/Leaderboard
     * */
    public SidePanel() {
        setPreferredSize(new Dimension(150, 200));
        setLayout(new BoxLayout(this, BoxLayout.Y_AXIS));
        setBackground(new Color(174,255,255));

        // Level label (text + Background)
        levelLabel = new JLabel("Level 01");
        levelLabel.setForeground(Color.black);
        levelLabel.setFont(new Font("Arial", Font.BOLD, 16));
        levelLabel.setAlignmentX(Component.CENTER_ALIGNMENT);
        levelLabel.setBorder(BorderFactory.createEmptyBorder(20,0,10,0));


        // Leaderboard text area
        leaderboardArea = new JTextArea(10, 12);
        leaderboardArea.setEditable(false);
        leaderboardArea.setFont(new Font("Monospaced", Font.PLAIN, 12));
        leaderboardArea.setBackground(new Color(200, 255, 255));
        leaderboardArea.setAlignmentX(Component.CENTER_ALIGNMENT);

        loadLeaderBoard();

        // Next piece component
        nextPiecePanel = new JPanel(){
            @Override
            protected void paintComponent(Graphics g){
                super.paintComponent(g);

                if(nextShape == null || nextColor == null) return;

                Graphics2D g2d = (Graphics2D) g;
                g2d.setColor(nextColor);

                int blockSize = 20;
                int pieceHeight = nextShape.length;
                int pieceWidth = nextShape[0].length;

                // centralize in panel
                int xOffset = (getWidth() - pieceWidth * blockSize) / 2;
                int yOffset = (getHeight() - pieceHeight * blockSize) / 2;

                for (int i = 0; i < pieceHeight; i++) {
                    for (int j = 0; j < pieceWidth; j++) {
                        if(nextShape[i][j] != 0){
                            g2d.setColor(nextColor);
                            g2d.fillRect(xOffset + j * blockSize, yOffset + i * blockSize, blockSize, blockSize);
                            g2d.setColor(Color.BLACK);
                            g2d.drawRect(xOffset + j * blockSize, yOffset + i * blockSize, blockSize, blockSize);
                        }
                    }
                }
            }
        };

        // Defining size properties
        nextPiecePanel.setPreferredSize(new Dimension(120, 120));
        nextPiecePanel.setMaximumSize(new Dimension(120, 120));
        nextPiecePanel.setBackground(new Color(20, 255, 255));
        nextPiecePanel.setAlignmentX(Component.CENTER_ALIGNMENT);

        // insert into the layout
        add(Box.createVerticalStrut(10));
        add(levelLabel);
        add(Box.createVerticalStrut(10));
        add(new JLabel("Leaderboard") {{
            setAlignmentX(Component.CENTER_ALIGNMENT);
            setFont(new Font("Arial", Font.BOLD, 14));
        }});
        add(Box.createVerticalStrut(5));
        add(leaderboardArea);
        add(Box.createVerticalStrut(10));
        add(new JLabel("Next") {{
            setAlignmentX(Component.CENTER_ALIGNMENT);
            setFont(new Font("Arial", Font.BOLD, 14));
        }});
        add(Box.createVerticalStrut(5));
        add(nextPiecePanel);
        add(Box.createVerticalGlue());
    }


    public void setLevel(int level){
        String label = String.format("%02d", level);
        levelLabel.setText("Level " + label);
    }

    public void setNextPiece(int[][] shape, Color color){
        this.nextShape = shape;
        this.nextColor = color;
        nextPiecePanel.repaint();
    }

    /**
     * Method responsible to open the score.txt file where is located all the best scores,
     * and sorts the content to display the best players.
     * */
    private void loadLeaderBoard(){
        StringBuilder leader = new StringBuilder();
        File file = new File("scores.txt");
        LinkedHashMap<String, Integer> userScore = new LinkedHashMap<>();

        try{
            Scanner reader = new Scanner(file);
            while(reader.hasNext()){
                String[] line = reader.nextLine().split(":");

                // <user, score>
                userScore.put(line[0], Integer.parseInt(line[1].trim()));

            }
            reader.close();

            List<Map.Entry<String, Integer>> sortedEntries = new ArrayList<>(userScore.entrySet());

            sortedEntries.sort((a, b) -> b.getValue().compareTo(a.getValue()));

            for(Map.Entry<String, Integer> entry : sortedEntries){
                leader.append(entry.getKey()).append(" - ").append(entry.getValue()).append("points").append("\n");
            }

        } catch(FileNotFoundException e){
            e.printStackTrace();
        }

        leaderboardArea.setText(leader.toString());

    }

}
