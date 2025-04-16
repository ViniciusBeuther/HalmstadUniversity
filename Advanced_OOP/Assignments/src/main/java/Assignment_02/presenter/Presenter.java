package presenter;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

import javax.swing.JButton;
import javax.swing.JComponent;
import javax.swing.JFrame;

public abstract class Presenter {

	public abstract JComponent createCenterComponent();
	
	public abstract void northButtonPressed();
	public abstract void eastButtonPressed();
	public abstract void southButtonPressed();
	public abstract void westButtonPressed();
	
	public Presenter() {
		JFrame frame = new JFrame();
		// setup layout manager for frame
		JButton northButton = new JButton("North");
		northButton.addActionListener(new ActionListener() {			
			@Override
			public void actionPerformed(ActionEvent e) {
				northButtonPressed();				
			}
		});
		// add northButton to a JPanel, add that panel to frame
		JComponent centerComponent = createCenterComponent();
		// add centerComponent to frame
		// create other components (text component, e.g.), add them to frame
		// show frame		
	}
	
	public void showText(String text) {
		// update the text component
	}
	
}
