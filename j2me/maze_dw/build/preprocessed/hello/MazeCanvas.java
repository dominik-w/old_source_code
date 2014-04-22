/*
 * MazeCanvas.java
 */

package hello;

import javax.microedition.lcdui.*;

/**
 * Maze canvas.
 * 
 * @author Dominik Wlazlowski
 */
public class MazeCanvas extends javax.microedition.lcdui.Canvas {

    // colors
    public static final int WHITE = 0xffffff;

    // public static final int BLACK = 0;
    public static final int BLUE = 0x0000ff;

    // device display handle
    private Display hDisplay;

    // maze cfg - grid
    private MazeGrid myGrid;

    // game state
    private boolean gameOverState = false;

    // dimensions and position pointers
    private int squareSize;
    private int maxSquareSize;
    private int minSquareSize;
    
    private int startX = 0;
    private int startY = 0;

    private int gridHeight;
    private int gridWidth;
    private int maxGridWidth;
    private int minGridWidth;
    
    private int oldX = 1;
    private int oldY = 1;
    private int playerX = 1;
    private int playerY = 1;

    /**
     * Column width setter.
     * @return int
     */
    public int setColWidth(int colWidth) {
        // do calculations using bitwise operations for max performance
        if (colWidth < 2) {
            squareSize = 2;
        } else {
            squareSize = colWidth;
        }

        gridWidth = getWidth() / squareSize;
        if ((gridWidth & 0x1) == 0) {
            gridWidth -= 1;
        }

        gridHeight = getHeight() / squareSize;

        if ((gridHeight & 0x1) == 0) {
            gridHeight -= 1;
        }

        myGrid = null;
        return gridWidth;
    }

    /**
     * Number of columns getter.
     * @return the number of maze columns
     */
    public int getNumCols() {
        return gridWidth;
    }

    /**
     * Minimum width of maze walls getter.
     * @return the minimum width
     */
    public int getMinColWidth() {
        return minSquareSize;
    }

    /**
     * Maximum width of maze walls getter.
     * @return the maximum width possible for the maze walls.
     */
    public int getMaxColWidth() {
        return maxSquareSize;
    }

    /**
     * Maximum columns number getter.
     * @return the maximum possible number of columns
     */
    public int getMaxNumCols() {
        return maxGridWidth;
    }

    /**
     * Columns width value getter.
     * @return the width of the maze walls.
     */
    public int getColWidth() {
        return squareSize;
    }

    /**
     * The constructor.
     * @param d
     * @throws Exception if the display of device is too small to make a maze
     */
    public MazeCanvas(Display d) throws Exception {

        hDisplay = d;
        int width = getWidth();
        int height = getHeight();

        squareSize = PreferencesStorage.getSquareSize();
        minSquareSize = 3;
        maxGridWidth = width / minSquareSize;
        
        if ((maxGridWidth & 0x1) == 0) {
            maxGridWidth -= 1;
        }

        gridWidth = width / squareSize;
        if ((gridWidth & 0x1) == 0) {
            gridWidth -= 1;
        }

        gridHeight = height / squareSize;
        if ((gridHeight & 0x1) == 0) {
            gridHeight -= 1;
        }

        minGridWidth = 15;
        maxSquareSize = width / minGridWidth;

        if (maxSquareSize > height / minGridWidth) {
            maxSquareSize = height / minGridWidth;
        }

        // check display of the device
        if (maxSquareSize < squareSize) {
            throw new Exception("Display of this device too small");
        }
    }

    /**
     * This is called as soon as the application begins.
     */
    public void start() {
        hDisplay.setCurrent(this);
        repaint();
    }

    /**
     * Draw new maze if needed.
     */
    public void newMaze() {
        gameOverState = false;
        myGrid = null;

        // player's pos
        playerX = 1;
        playerY = 1;
        oldX = 1;
        oldY = 1;
        hDisplay.setCurrent(this);

        repaint();
    }

    /**
     * Create and display a maze if necessary, move the player otherwise.
     * @param g
     */
    protected void paint(Graphics g) {
        
        if (myGrid == null) {
            int width = getWidth();
            int height = getHeight();

            myGrid = new MazeGrid(gridWidth, gridHeight);

            // draw the maze
            for (int i = 0; i < gridWidth; i++) {
                for (int j = 0; j < gridHeight; j++) {
                    if (myGrid.gameSquares[i][j] == 0) {
                        g.setColor(BLUE);
                    } else {
                        g.setColor(WHITE);
                    }

                    // fill the square
                    g.fillRect(startX + (i * squareSize), startY + (j * squareSize),
                            squareSize, squareSize);
                }
            }

            // fill the extra space outside of the maze
            g.setColor(BLUE);
            g.fillRect(startX + ((gridWidth - 1) * squareSize), startY, width, height);

            // exit path - clean
            g.setColor(WHITE);
            g.fillRect(startX + ((gridWidth - 1) * squareSize),
                    startY + ((gridHeight - 2) * squareSize), width, height);

            // fill the extra space outside of the maze
            g.setColor(BLUE);
            g.fillRect(startX, startY + ((gridHeight - 1) * squareSize), width, height);
        }

        // draw the player
        g.setColor(255, 0, 0); // red
        g.fillRoundRect(startX + (squareSize) * playerX, startY + (squareSize) * playerY,
                squareSize, squareSize, squareSize, squareSize);

        // cleanup of previous location
        if ((oldX != playerX) || (oldY != playerY)) {
            g.setColor(WHITE);
            g.fillRect(startX + (squareSize) * oldX, startY + (squareSize) * oldY,
                    squareSize, squareSize);
        }

        // maze completed sub-procedure
        if (gameOverState) {
            int width = getWidth();
            int height = getHeight();
            String _msg = "Game Completed! Congratulations!";
            
            Font font = g.getFont();
            
            int fontHeight = font.getHeight() + 4;
            int fontWidth = font.stringWidth(_msg);
            g.setColor(WHITE);
            g.fillRect( (width - fontWidth) / 2, (height - fontHeight) / 2,
                    fontWidth + 2, fontHeight );
            g.setColor(255, 0, 0);
            g.setFont(font);
            g.drawString(_msg, (width - fontWidth) / 2, (height - fontHeight) / 2, g.TOP | g.LEFT);
        }
    }

    /**
     * Key input processor with moving the player implementation.
     * @param keyCode
     */
    public void keyPressed(int keyCode) {
        if (!gameOverState) {
            int action = getGameAction(keyCode);

            switch (action) {
                case LEFT:
                    if ((myGrid.gameSquares[playerX - 1][playerY] == 1) &&
                            (playerX != 1)) {
                        oldX = playerX;
                        oldY = playerY;
                        playerX -= 2;
                        
                        repaint();
                    }
                    break;
                case RIGHT:
                    if (myGrid.gameSquares[playerX + 1][playerY] == 1) {
                        oldX = playerX;
                        oldY = playerY;
                        playerX += 2;
                        
                        repaint();
                    } else if ((playerX == myGrid.gameSquares.length - 2) &&
                            (playerY == myGrid.gameSquares[0].length - 2)) {
                        oldX = playerX;
                        oldY = playerY;
                        playerX += 2;
                        gameOverState = true;

                        repaint();
                    }
                    break;
                case UP:
                    if (myGrid.gameSquares[playerX][playerY - 1] == 1) {
                        oldX = playerX;
                        oldY = playerY;
                        playerY -= 2;

                        repaint();
                    }
                    break;
                case DOWN:
                    if (myGrid.gameSquares[playerX][playerY + 1] == 1) {
                        oldX = playerX;
                        oldY = playerY;
                        playerY += 2;
                        
                        repaint();
                    }
                    break;
            }
        }
    }
}
