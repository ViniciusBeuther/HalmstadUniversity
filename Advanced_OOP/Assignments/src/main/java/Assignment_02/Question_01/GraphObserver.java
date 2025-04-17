package Assignment_02.Question_01;

import javax.swing.*;
import java.awt.*;

public class GraphObserver extends JPanel implements Observer {
    private double value = 0;

    @Override
    public void update(double value) {
        this.value = value;
        repaint();
    }

    @Override
    protected void paintComponent(Graphics g) {
        super.paintComponent(g);
        super.setBackground(Color.BLACK);
        int height = (int) (getHeight() - (value / 100.0) * getHeight());
        g.setColor(Color.GREEN);
        g.fillRect(90, height, 50, getHeight() - height);
    }

    @Override
    public Dimension getPreferredSize() {
        return new Dimension(240, 500);
    }
}
