package Assignment_02.Question_04;

import javax.swing.*;

public class ObserverGraph {
    public static void main(String[] args){
        SwingUtilities.invokeLater(() -> {
            NumberModel numbers = new NumberModel(5);

            JFrame numbersFrame = new JFrame("Number editor");
            numbersFrame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
            numbersFrame.add(new NumberView(numbers));
            numbersFrame.pack();
            numbersFrame.setLocation(100, 100);
            numbersFrame.setVisible(true);

            JFrame graphFrame = new JFrame("Graph view");
            graphFrame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
            graphFrame.add(new GraphView(numbers));
            graphFrame.pack();
            graphFrame.setLocation(350, 100);
            graphFrame.setVisible(true);
        });
    }
}
