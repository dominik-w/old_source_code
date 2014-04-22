/*
 * SelectScreen.java
 */

package hello;

import javax.microedition.lcdui.*;

/**
 * Settings form.
 * 
 * @author Dominik Wlazlowski
 */
public class SelectScreen extends Form implements ItemStateListener, CommandListener  {

    private Command exitCommand = new Command("OK", Command.EXIT, 1);

    private Gauge columnsGauge;
    private Gauge widthGauge;
    
    // a handle to the main game canvas
    private MazeCanvas gameCanvas;

    /**
     * Create UI and place it on the screen.
     * @param canvas
     */
    public SelectScreen(MazeCanvas canvas) {
        super("Maze Preferences");
        addCommand(exitCommand);
        setCommandListener(this);
        gameCanvas = canvas;
        setItemStateListener(this);

        widthGauge = new Gauge("Column Width", true, gameCanvas.getMaxColWidth() * 2,
                gameCanvas.getColWidth() * 2);
        widthGauge.setLayout(Item.LAYOUT_CENTER);
        
        columnsGauge = new Gauge("Number of Columns", false, gameCanvas.getMaxNumCols() / 2,
                gameCanvas.getNumCols() / 2);

        columnsGauge.setLayout(Item.LAYOUT_CENTER);

        append(widthGauge);
        append(columnsGauge);
    }

    /**
     * Changing the width handler.
     * @param item
     */
    public void itemStateChanged(Item item) {
        if (item == widthGauge) {
            int val = widthGauge.getValue();
            if (val < gameCanvas.getMinColWidth()) {
                widthGauge.setValue(gameCanvas.getMinColWidth());
            } else {
                int numCols = gameCanvas.setColWidth(val);
                columnsGauge.setValue(numCols);
            }
        }
    }

    /**
     * Command processor.
     * @param c
     * @param s
     */
    public void commandAction(Command c, Displayable s) {
        if (c == exitCommand) {
            PreferencesStorage.setSquareSize(widthGauge.getValue());
            gameCanvas.newMaze();
        }
    }
}
