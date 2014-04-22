/*
 * dwSnake - A simple Nokia 3210 like snake implementation.
 * 
 * @author Dominik Wlazlowski <dominik-w@dominik-w.pl>
 * @version 0.05
 */

package dwsnake;

import javax.swing.JFrame;

/**
 * Main game class.
 * 
 * @author Dominik Wlazlowski
 */
public class Snake extends JFrame {

    private final static String version = "v. 0.05";

    /**
     * The constructor.
     */
    public Snake() {
        add(new SnakeBoard()); // game core

        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setSize(420, 440);
        setLocationRelativeTo(null);
        setTitle("dwSnake " + version);
        setVisible(true);
        setResizable(false);
    }

    public static void main(String[] args) {        
        new Snake();
    }
}
