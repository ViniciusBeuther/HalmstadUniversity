package FinalProject_Tetris.Misc;

import javax.sound.sampled.*;
import java.io.InputStream;

public class SoundUtils {
    public static void playSound(String resourcePath) {
        new Thread(() -> {
            try {
                InputStream audioSrc = SoundUtils.class.getResourceAsStream(resourcePath);

                AudioInputStream audioStream = AudioSystem.getAudioInputStream(audioSrc);
                Clip clip = AudioSystem.getClip();

                clip.addLineListener(event -> {
                    if (event.getType() == LineEvent.Type.STOP) {
                        clip.close();
                    }
                });

                clip.open(audioStream);
                clip.start();
            } catch (Exception e) {
                e.printStackTrace();
            }
        }).start();
    }

}
