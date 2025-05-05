package Assignment_02.Question_01;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.util.ArrayList;
import javax.swing.Timer;

public class Signal {
    private Sampler sampler;
    private ArrayList<Observer> theObservers;
    private final int SAMPLING = 1000;

    // Constructor, where we start the timer loop and the observers array
    public Signal() {
        this.sampler = new SinusSampler();

        theObservers = new ArrayList<>();
        System.out.println("Signal constructor");

        Timer t = new Timer(SAMPLING, e -> {
            double value = this.sampler.getValue();
            System.out.println("Value generated: " + value);
            nextValue(value);
        });
        t.start();
    }

    // Add the observer
    public void addSignalToObserver(Observer o) {
        theObservers.add(o);
    }

    // Updates the observer value for the next one
    private void nextValue(double x) {
        for (Observer o : theObservers) {
            o.update(x);
        }
    }
}
