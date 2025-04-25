package Assignment_02.Question_04;

import java.util.ArrayList;
import java.util.List;

public class NumberModel {

    // Initialize variables and observers
    private List<Double> numbers;
    private List<ModelObserver> observers;

    // constructor, it receives a standard size (number of bars/inputs)
    public NumberModel(int size){
        numbers = new ArrayList<>();
        observers = new ArrayList<>();

        // Initialize all values as 0.0
        for(int i=0; i < size; i++){
            numbers.add(0.0);
        }
    }

    // Set a number in determined index
    public void setNumber(int index, double value){
        numbers.set(index, value);
        notifyObserver();
    }

    // Get list of numbers
    public List<Double> getNumbers(){
        return numbers;
    }

    // Add observer to list
    public void addObserver(ModelObserver observer){
        observers.add(observer);
    }

    // Notify the observer when number changes
    public void notifyObserver(){
        for(ModelObserver observer : observers){
            observer.modelChanged();
        }
    }
}
