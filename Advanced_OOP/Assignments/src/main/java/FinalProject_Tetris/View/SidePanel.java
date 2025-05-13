package FinalProject_Tetris.View;

import javax.swing.*;
import java.awt.*;

public class SidePanel extends JPanel {
    private JLabel levelLabel;
    private JPanel nextPiecePanel;
    private int[][] nextShape;
    private Color nextColor;

    public SidePanel(){
        setPreferredSize(new Dimension(150, 400));
        setLayout(new BorderLayout());
        setBackground(Color.DARK_GRAY);

        levelLabel = new JLabel("Level 01");
        levelLabel.setForeground(Color.white);
        levelLabel.setFont(new Font("Arial", Font.BOLD, 16));
        levelLabel.setVerticalAlignment(SwingConstants.CENTER);
        levelLabel.setBorder(BorderFactory.createEmptyBorder(20,0,10,0));

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

        nextPiecePanel.setPreferredSize(new Dimension(100, 100));
        nextPiecePanel.setBackground(Color.BLACK);
        add(levelLabel, BorderLayout.NORTH);
        add(nextPiecePanel, BorderLayout.CENTER);
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


}
