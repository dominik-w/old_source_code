package firstticket;

import java.io.*;
import sun.audio.*;

/**
 * Simple sound alarm.
 * 
 * @author Dominik Wlazlowski | http://www.directcode.eu/
 * @version 1.2
 */
public class Alarm {
    
    // public Alarm  () {}
    
    /**
     * Play standard sound.
     */
    public void playSound() {
        AudioStream as = null;

        try {
            as = new AudioStream(this.getClass().getResourceAsStream("resources/alarma.wav"));
        } catch (IOException e) { /* e.printStackTrace(); */ }
        
        AudioPlayer.player.start(as);
        // AudioPlayer.player.stop(as);
    }
    
    /**
     * Play sound for time confirm.
     */
    public void playTimeConfirmSound() {
        AudioStream as = null;

        try {
            as = new AudioStream(this.getClass().getResourceAsStream("resources/time_confirm.wav"));
        } catch (IOException e) { /* e.printStackTrace(); */ }
        
        AudioPlayer.player.start(as);
        // AudioPlayer.player.stop(as);
    }
    
    /**
     * Play timeout alarm sound.
     */
    public void playTimeoutSound() {
        AudioStream as = null;

        try {
            as = new AudioStream(this.getClass().getResourceAsStream("resources/timeout.wav"));
        } catch (IOException e) { /* e.printStackTrace(); */ }
        
        AudioPlayer.player.start(as);
        // AudioPlayer.player.stop(as);
    }

    /**
     * Play error or deadlock alarm sound.
     */
    public void playErrorSound() {
        AudioStream as = null;

        try {
            as = new AudioStream(this.getClass().getResourceAsStream("resources/error.wav"));
        } catch (IOException e) { /* e.printStackTrace(); */ }
        
        AudioPlayer.player.start(as);
        // AudioPlayer.player.stop(as);
    }
    
}
