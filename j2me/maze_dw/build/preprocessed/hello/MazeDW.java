/*
 * Maze DW - a simple game with maze implementation. J2ME version.
 */

package hello;

import javax.microedition.midlet.*;
import javax.microedition.lcdui.*;

/**
 * Midlet class.
 * 
 * @author Dominik Wlazlowski
 */
public class MazeDW extends MIDlet implements CommandListener {

    // the canvas handle
    private MazeCanvas hCanvas;

    // settings screen
    private SelectScreen selectScreen;

    // game midlet commands
    private Command newCommand = new Command("New maze", Command.SCREEN, 1);
    private Command exitCommand = new Command("Exit", Command.EXIT, 99);
    private Command alertDoneCommand = new Command("Done", Command.EXIT, 1);
    private Command preferencesCommand = new Command("Maze settings", Command.SCREEN, 1);
    
    /**
     * The constructor.
     */
    public MazeDW() {
    }

    /**
     * Application starter.
     * @throws MIDletStateChangeException
     */
    public void startApp() throws MIDletStateChangeException {
        try {
            hCanvas = new MazeCanvas(Display.getDisplay(this));
            hCanvas.addCommand(exitCommand);
            hCanvas.addCommand(newCommand);
            hCanvas.addCommand(preferencesCommand);
            hCanvas.setCommandListener(this);
            hCanvas.start();
        } catch(Exception e) {
            Alert errorAlert = new Alert("error", e.getMessage(), null, AlertType.ERROR);
            errorAlert.setCommandListener(this);
            errorAlert.setTimeout(Alert.FOREVER);
            errorAlert.addCommand(alertDoneCommand);
            Display.getDisplay(this).setCurrent(errorAlert);
        }
    }

    /**
     * Clean up.
     */
    public void destroyApp(boolean unconditional) throws MIDletStateChangeException {
        hCanvas = null;
        System.gc();
    }

    /**
     * App pause.
     */
    public void pauseApp() {
    }

    /**
     * Command processor.
     */
    public void commandAction(Command c, Displayable s) {
        if (c == newCommand) {
            hCanvas.newMaze();
        } else if (c == alertDoneCommand) {
            try {
                destroyApp(false);
                notifyDestroyed();
            } catch (MIDletStateChangeException ex) { }
        } else if (c == preferencesCommand) {
            if (selectScreen == null) {
                selectScreen = new SelectScreen(hCanvas);
            }
            Display.getDisplay(this).setCurrent(selectScreen);
        } else if (c == exitCommand) {
            try {
                destroyApp(false);
                notifyDestroyed();
            } catch (MIDletStateChangeException ex) { }
        }
    }
}
