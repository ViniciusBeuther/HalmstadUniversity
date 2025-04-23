package Assignment_02.Question_04;

import java.util.ArrayList;
import java.util.List;

public class NumberModel {
    private List<Double> numbers;
    private List<ModelObserver> observers;

    public NumberModel(int size){
        numbers = new ArrayList<>();
        observers = new ArrayList<>();

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
