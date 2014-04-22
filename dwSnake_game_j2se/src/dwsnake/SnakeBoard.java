/*
 * Game board and snake implementation.
 */

package dwsnake;

import java.awt.Font;
import java.awt.FontMetrics;
import java.awt.Graphics;
import java.awt.Image;
import java.awt.Color;
import java.awt.Toolkit;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.KeyEvent;
import java.awt.event.KeyAdapter;

import javax.swing.ImageIcon;
import javax.swing.JPanel;
import javax.swing.Timer;

/**
 * Snake game board.
 * 
 * @author Dominik Wlazlowski
 */
public class SnakeBoard extends JPanel implements ActionListener {

    // board dimensions
    private final int WIDTH = 400;
    private final int HEIGHT = 400;

    private final int BRICK_SIZE = 10;
    private final int _POS = 22; // for random position compute
    
    // ALL_BRICKS constant defines the maximum number of possible bricks on the board
    // formula: (ALL_BRICKS = WIDTH * HEIGHT / BRICK_SIZE * BRICK_SIZE)    
    private final int ALL_BRICKS = 1600;
    
    private final int DELAY = 110;

    private int x[] = new int[ALL_BRICKS];
    private int y[] = new int[ALL_BRICKS];

    private int bricks;
    private int apple_x;
    private int apple_y;

    private boolean left        = false;
    private boolean right       = true;
    private boolean up          = false;
    private boolean down        = false;
    private boolean gameStateOk = true;

    private Timer timer;
    private Image dot; // for single "brick"
    private Image apple;
    private Image head;

    private static int _score = 0;

    /**
     * The constructor.
     */
    public SnakeBoard() {
        addKeyListener(new InputProcessor());

        // set black color for background
        int bgc = 0x000000;
        setBackground(new Color(bgc));

        ImageIcon img_dot = new ImageIcon(this.getClass().getResource("/gfx/dot.png"));
        dot = img_dot.getImage();

        ImageIcon img_apple = new ImageIcon(this.getClass().getResource("/gfx/apple.png"));
        apple = img_apple.getImage();

        ImageIcon img_head = new ImageIcon(this.getClass().getResource("/gfx/head.png"));
        head = img_head.getImage();

        setFocusable(true);
        initGame();
    }

    /**
     * Init.
     */
    public void initGame() {
        bricks = 5;

        for (int i = 0; i < bricks; i++) {
            x[i] = 50 - i * 10;
            y[i] = 50;
        }

        locateApple();

        timer = new Timer(DELAY, this);
        timer.start();
    }

    /**
     * Overridden painting method.
     * 
     * @param g
     */
    @Override public void paint(Graphics g) {
        super.paint(g);

        if (gameStateOk) {
            g.drawImage(apple, apple_x, apple_y, this);

            for (int i = 0; i < bricks; i++) {
                if (i == 0)
                    g.drawImage(head, x[i], y[i], this);
                else
                    g.drawImage(dot, x[i], y[i], this);
            }

            // graphics state sync
            Toolkit.getDefaultToolkit().sync();
            g.dispose();
        } else {
            gameOver(g);
        }
    }

    /**
     * Game over procedure.
     * 
     * @param g
     */
    public void gameOver(Graphics g) {
        String msg = "LOL! You lost :-) Score: " + _score;
        Font msg_font = new Font("Courier New", Font.BOLD, 16);
        FontMetrics metr = this.getFontMetrics(msg_font);

        int msg_color = 0x00dd00;
        g.setColor(new Color(msg_color));
        g.setFont(msg_font);
        g.drawString(msg, (WIDTH - metr.stringWidth(msg)) / 2, HEIGHT / 2);
    }

    /**
     * Checks if snake's head and apple are on the same position.
     */
    public void checkApple() {
        if ( (x[0] == apple_x) && (y[0] == apple_y) ) {
            bricks++;
            locateApple();
            _score += 10;
        }
    }

    /**
     * Moves the snake.
     */
    public void move() {
        for (int i = bricks; i > 0; i--) {
            x[i] = x[(i - 1)];
            y[i] = y[(i - 1)];
        }

        if (left) {
            x[0] -= BRICK_SIZE;
        }

        if (right) {
            x[0] += BRICK_SIZE;
        }

        if (up) {
            y[0] -= BRICK_SIZE;
        }

        if (down) {
            y[0] += BRICK_SIZE;
        }
    }

    /**
     * Collision detector.
     */
    public void checkForCollision() {
        for (int i = bricks; i > 0; i--) {
            if ( (i > 4) && (x[0] == x[i]) && (y[0] == y[i]) ) {
                gameStateOk = false;
            }
        }

        if (y[0] > HEIGHT) {
            gameStateOk = false;
        }

        if (y[0] < 0) {
            gameStateOk = false;
        }

        if (x[0] > WIDTH) {
            gameStateOk = false;
        }

        if (x[0] < 0) {
            gameStateOk = false;
        }
    }

    /**
     * Locates new apple.
     */
    public void locateApple() {
        int rand = (int) (Math.random() * _POS);
        apple_x = ((rand * BRICK_SIZE));
        rand = (int) (Math.random() * _POS);
        apple_y = ((rand * BRICK_SIZE));
    }

    /**
     * Events processor.
     * 
     * @param e
     */
    public void actionPerformed(ActionEvent e) {
        if (gameStateOk) {
            checkApple();
            checkForCollision();
            move();
        }

        repaint();
    }

    private class InputProcessor extends KeyAdapter {
        // process keyboard input
        @Override public void keyPressed(KeyEvent e) {
            int key = e.getKeyCode();

            // handle all cases
            if ( (key == KeyEvent.VK_LEFT) && (!right) ) {
                left = true;
                up   = false;
                down = false;
            }

            if ( (key == KeyEvent.VK_RIGHT) && (!left) ) {
                right = true;
                up    = false;
                down  = false;
            }

            if ( (key == KeyEvent.VK_UP) && (!down) ) {
                up    = true;
                right = false;
                left  = false;
            }

            if ( (key == KeyEvent.VK_DOWN) && (!up) ) {
                down  = true;
                right = false;
                left  = false;
            }
        }
    }
}
