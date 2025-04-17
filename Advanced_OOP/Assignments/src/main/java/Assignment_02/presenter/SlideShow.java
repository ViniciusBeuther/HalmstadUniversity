package presenter;

import java.io.File;

import javax.swing.JComponent;

public class SlideShow extends presenter.Presenter {

	private JComponent pictureComponent = null;
	
	public SlideShow(File[] imageFiles, String[] texts) {
		// read and remember (create instance variables)
		// images from the indicated files
		// and also remember texts in an instance field
	}
	
	@Override
	public JComponent createCenterComponent() {
		// create picture Component
		// you may want to create a class for that
		// (class PictureComponent extends JComponent { ... } )
		return pictureComponent;
	}

	@Override
	public void eastButtonPressed() {
		// make pictureComponent display the next picture
		// call showText(...) to update the text associated with picture
		// one possible way of drawing images is
		// in paintComponent
		// BufferedImage image = ImageIO.read(<File object>);
		// Graphics2D g2 = (Graphics2D)g;
		// g2.drawImage(image, null, <posX>, <posY>);
		// Google will give details
	}
	
	@Override
	public void westButtonPressed() {
		// same as for east button, but for previous picture
	}

	@Override
	public void southButtonPressed() {
	}

	@Override
	public void northButtonPressed() {
	}
	
	public static void main(String[] args) {
		SlideShow app = new SlideShow(
				new File[] { new File("pic1.jpg"), new File("pic2.jpg")},
				new String[] {"Descirption 1", "Description 2"});				
	}

}
