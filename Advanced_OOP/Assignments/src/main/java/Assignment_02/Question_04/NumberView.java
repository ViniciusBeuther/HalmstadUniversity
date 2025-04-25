package Assignment_02.Question_04;

import javax.swing.*;
import java.awt.*;
import java.awt.event.KeyAdapter;
import java.awt.event.KeyEvent;
import java.util.ArrayList;
import java.util.List;

public class NumberView extends JPanel implements ModelObserver {
    // Declare class attributes
    private NumberModel model;
    private List<JTextField> fields;

    // constructor
    public NumberView(NumberModel model){
        // Get the number model and initialize fields
        this.model = model;
        this.fields = new ArrayList<>();

        // add observer
        model.addObserver(this);

        // Define the layout type
        setLayout(new GridLayout(model.getNumbers().size(), 1, 5, 5));

        // Loop the numbers and create fields
        for(int i = 0; i < model.getNumbers().size(); i++){
            JTextField field = new JTextField(model.getNumbers().get(i).toString());
            fields.add(field); // Save reference for later updates

            int index = i;

            // Update value when user edit the field
            field.addActionListener(e -> {
                double value = Double.parseDouble(field.getText());
                model.setNumber(index, value);
            });

            // handle updates, when key is released
            field.addKeyListener(new KeyAdapter() {
                public void keyReleased(KeyEvent event){
                    double value = Double.parseDouble(field.getText());
                    model.setNumber(index, value);
                }
            });

            add(field);
        }
    }


    // Update interface and handle model changes
    @Override
    public void modelChanged(){
        List<Double> numbers = model.getNumbers();
        for(int i = 0; i < numbers.size(); i++){
            fields.get(i).setText(String.format("%.2f", numbers.get(i)));
        }
    }
}
