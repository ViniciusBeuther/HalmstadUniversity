package Assignment_02.Question_01;

import javax.swing.*;
import java.awt.*;

public class TextObserver extends JLabel implements Observer {
    // Constructor, it sets the initial value label
    public TextObserver(){
        super("Value: 0.0");
        setFont(new Font("Arial", Font.BOLD,16));
        setHorizontalAlignment(SwingConstants.CENTER);
    }

    // Update text value on window
    @Override
    public void update(double x){
        setText(String.format("Value: %.2f", x));
    }
}
