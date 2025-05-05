package Assignment_02.Question_01;

import javax.swing.*;

public class Main {
    public static void main(String[] args) {
        SwingUtilities.invokeLater(() -> {
            // Create sampler and signal instances

            Signal signal = new Signal();

            // Create the graph and text observer that will be placed on the window
            GraphObserver graph = new GraphObserver();
            TextObserver text = new TextObserver();

            // Add the graph and text to be watched by the observer
            signal.addSignalToObserver(graph);
            signal.addSignalToObserver(text);

            // Create and set window position
            JFrame frame = new JFrame("Signal Viewer");
            frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
            frame.setLayout(new BoxLayout(frame.getContentPane(), BoxLayout.Y_AXIS));
            frame.add(graph);
            frame.add(text);
            frame.pack();
            frame.setVisible(true);
        });
    }
}
