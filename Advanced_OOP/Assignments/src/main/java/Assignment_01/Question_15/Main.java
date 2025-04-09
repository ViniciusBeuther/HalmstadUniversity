package Assignment_01.Question_15;

import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionListener;
import java.awt.geom.Ellipse2D;

class ShapeDrawing extends JPanel{
    private Color color = Color.WHITE;

    public void setColor(Color color){
        this.color = color;
        repaint();
    }

    @Override
    protected void paintComponent(Graphics g){
        super.paintComponent(g);
        Graphics2D g2 = (Graphics2D) g;
        g2.setColor(this.color);
        Shape ellipse = new Ellipse2D.Double(50, 50, 100, 100);
        g2.fill(ellipse);
        g2.draw(ellipse);
    }

    @Override
    public Dimension getPreferredSize(){
        return new Dimension(200, 200);
    }
}

public class Main {
    public static void main(String[] args){

        // Instantiate a frame, set to be visible and define the default operation when hits close
        JFrame frame = new JFrame();

        ShapeDrawing sd = new ShapeDrawing();

        JButton redButton = new JButton("Red");
        JButton blueButton = new JButton("Blue");
        JButton greenButton = new JButton("Green");

        redButton.addActionListener(event -> sd.setColor(Color.RED));
        greenButton.addActionListener(event -> sd.setColor(Color.GREEN));
        blueButton.addActionListener(event -> sd.setColor(Color.BLUE));

        frame.setLayout(new FlowLayout());

        frame.add(redButton);
        frame.add(greenButton);
        frame.add(blueButton);
        frame.add(sd);

        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.pack();
        frame.setVisible(true);
    }

}
