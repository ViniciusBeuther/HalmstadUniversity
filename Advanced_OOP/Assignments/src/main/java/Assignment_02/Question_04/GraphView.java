package Assignment_02.Question_04;

import javax.swing.*;
import java.awt.*;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import java.util.List;
import java.util.Random;

public class GraphView extends JPanel implements ModelObserver {
    private NumberModel model;

    public GraphView(NumberModel model){
        this.model = model;
        model.addObserver(this);
        setPreferredSize(new Dimension(400, 300));

        // Listener to edit values by click in graph
        addMouseListener(new MouseAdapter() {
            @Override
            public void mousePressed(MouseEvent e) {
                List<Double> numbers = model.getNumbers();
                int barWidth = getWidth() / numbers.size();
                int clickedIndex = e.getX() / barWidth;

                if(clickedIndex >= 0 && clickedIndex < numbers.size()) {
                    double max = getMaxValue(numbers);
                    int height = getHeight();
                    double clickedValue = ((double)(height - e.getY()) / (height - 20)) * max;

                    // used to avoid negative values
                    clickedValue = Math.max(0.0, clickedValue);

                    model.setNumber(clickedIndex, clickedValue);
                }
            }
        });
    }

    // Get the maximum value based on a List<double>
    private double getMaxValue(List<Double> numbers) {
        double max = 1.0;
        for(double number : numbers){
            if(number > max){
                max = number;
            }
        }
        return max;
    }

    // Paint components
    @Override
    protected void paintComponent(Graphics g){
        // call parent method
        super.paintComponent(g);

        // Initialize numbers
        List<Double> numbers = this.model.getNumbers();

        // early return if the list is empty
        if(numbers.isEmpty()) return;

        // set max value
        double max = getMaxValue(numbers);

        // defining width/height and calculate the barWidth
        int width = getWidth();
        int height = getHeight();
        int barWidth = width / numbers.size();


        // Loop over the numbers and calculate positions/size
        for(int i=0; i<numbers.size(); i++){
            int barHeight = (int) ((numbers.get(i) / max) * (height - 20));
            int x = i * barWidth;
            int y = height - barHeight;

            // Add random colors for each bar and fill it
            Random rand = new Random(i);
            float red = rand.nextFloat();
            float green = rand.nextFloat();
            float blue = rand.nextFloat();

            // create a new color with RGB randomly generated
            g.setColor(new Color(red, green, blue));

            // paint bar
            g.fillRect(x + 5, y, barWidth - 10, barHeight);
        }
    }

    // Method to repaint and update when the model changes
    @Override
    public void modelChanged(){
        repaint();
    }
}
