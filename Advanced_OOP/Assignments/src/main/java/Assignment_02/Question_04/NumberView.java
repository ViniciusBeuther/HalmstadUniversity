package Assignment_02.Question_04;

import javax.swing.*;
import java.awt.*;
import java.awt.event.KeyAdapter;
import java.awt.event.KeyEvent;

public class NumberView extends JPanel {

    public NumberView(NumberModel model){
        setLayout(new GridLayout(model.getNumbers().size(), 1, 5, 5));

        // Loop thru the values on Number Model and display it in the window
        for(int i=0; i < model.getNumbers().size(); i++){
            JTextField field = new JTextField(model.getNumbers().get(i).toString());
            int index = i;
            field.addActionListener(e-> {
                double value = Double.parseDouble(field.getText());
                model.setNumber(index, value);
            });

            field.addKeyListener(new KeyAdapter() {
                public void keyReleased(KeyEvent event){
                    double value = Double.parseDouble(field.getText());
                    model.setNumber(index, value);
                }
            });

            // add the field to the interface
            add(field);
        }
    }
}
