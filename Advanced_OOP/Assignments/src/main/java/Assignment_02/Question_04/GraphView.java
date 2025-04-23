package Assignment_02.Question_04;

import javax.swing.*;
import java.awt.*;
import java.util.List;
import java.util.Random;

public class GraphView extends JPanel implements ModelObserver {
    private NumberModel model;

    // constructor
    public GraphView(NumberModel model){
        this.model = model;
        model.addObserver(this);
        setPreferredSize(new Dimension(400, 300));
    }

    // Plot chart
    @Override
    protected void paintComponent(Graphics g){
        super.paintComponent(g);
        List<Double> numbers = this.model.getNumbers();

        if(numbers.isEmpty()) return;

        double max = 1.0;
        for(double number : numbers){
            if(number > max){
                max = number;
            }
        }

        int width = getWidth();
        int height = getHeight();
        int barWidth = width / numbers.size();

        for(int i=0; i<numbers.size(); i++){
            int barHeight = (int) ((numbers.get(i) / max) * (height - 20));
            int x = i * barWidth;
            int y = height - barHeight;

            Random rand = new Random();
            float red = rand.nextFloat();
            float green = rand.nextFloat();
            float blue = rand.nextFloat();
            g.setColor(new Color(red, green, blue));

            g.fillRect(x + 5, y, barWidth - 10, barHeight);
        }
    }

    // set observer method
    @Override
    public void modelChanged(){
        repaint();
    }
}
