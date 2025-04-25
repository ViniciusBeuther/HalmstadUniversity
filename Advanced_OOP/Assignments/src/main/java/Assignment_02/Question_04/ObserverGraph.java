package Assignment_02.Question_04;

import javax.swing.*;

public class ObserverGraph {
    // Main running method
    public static void main(String[] args){
        SwingUtilities.invokeLater(() -> {
            // Initialize number of fields/bars
            NumberModel numbers = new NumberModel(7);

            // instantiate numbers frame, set default close operation, add to it the Number view interface, and set location and to be visible
            JFrame numbersFrame = new JFrame("Number editor");
            numbersFrame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
            numbersFrame.add(new NumberView(numbers));
            numbersFrame.pack();
            numbersFrame.setLocation(100, 100);
            numbersFrame.setVisible(true);

            // instantiate the graph frame, set default operation, insert graph view and also set the positions and to be visible
            JFrame graphFrame = new JFrame("Graph view");
            graphFrame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
            graphFrame.add(new GraphView(numbers));
            graphFrame.pack();
            graphFrame.setLocation(350, 100);
            graphFrame.setVisible(true);
        });
    }
}
