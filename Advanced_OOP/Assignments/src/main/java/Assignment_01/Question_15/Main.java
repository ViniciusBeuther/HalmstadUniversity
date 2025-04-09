package Assignment_01.Question_15;

import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionListener;
import java.awt.geom.Ellipse2D;

// Class to handle the icon drawing/color
class ShapeDrawing extends JPanel{
    private Color color = Color.WHITE;

    // Method to define the circle color
    public void setColor(Color color){
        this.color = color;
        repaint();
    }

    // Method that draw the ellipse
    @Override
    protected void paintComponent(Graphics g){
        super.paintComponent(g);
        Graphics2D g2 = (Graphics2D) g;
        g2.setColor(this.color);
        Shape ellipse = new Ellipse2D.Double(50, 50, 100, 100);
        g2.fill(ellipse);
        g2.draw(ellipse);
    }

    // Adjust the window size
    @Override
    public Dimension getPreferredSize(){
        return new Dimension(200, 200);
    }
}

public class Main {
    public static void main(String[] args){

        // Instantiate a frame, set to be visible and define the default operation when hits close
        JFrame frame = new JFrame();

        // Initialize ellipse shaping
        ShapeDrawing sd = new ShapeDrawing();

        // Define buttons
        JButton redButton = new JButton("Red");
        JButton blueButton = new JButton("Blue");
        JButton greenButton = new JButton("Green");

        // Add event listener to the buttons
        redButton.addActionListener(event -> sd.setColor(Color.RED));
        greenButton.addActionListener(event -> sd.setColor(Color.GREEN));
        blueButton.addActionListener(event -> sd.setColor(Color.BLUE));

        // Define layout
        frame.setLayout(new FlowLayout());

        // Add components to the frame
        frame.add(redButton);
        frame.add(greenButton);
        frame.add(blueButton);
        frame.add(sd);

        // Start the frame and define the default function to close window
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.pack();
        frame.setVisible(true);
    }

}
