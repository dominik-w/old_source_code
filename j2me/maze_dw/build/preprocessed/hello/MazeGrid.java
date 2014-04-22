/*
 * MazeGrid.java
 */

package hello;

import java.util.Vector;
import java.util.Random;

/**
 * Drawing maze manager.
 * 
 * @author Dominik Wlazlowski
 */
public class MazeGrid {

    // start maze generation with random number, so init random generator
    private Random _random = new Random();
    
    // squares fill data
    int[][] gameSquares;

    /**
     * The constructor.
     * @param width
     * @param height
     */
    public MazeGrid(int width, int height) {
        gameSquares = new int[width][height];
        for (int i = 1; i < width - 1; i++) {
            for (int j = 1; j < height - 1; j++) {
                if (((i & 0x1) != 0) || ((j & 0x1) != 0)) {
                    gameSquares[i][j] = 1;
                }
            }
        }
        gameSquares[0][1] = 1;
        buildMaze();
    }

    /**
     * Maze generator.
     */
    private void buildMaze() {
        for (int i = 1; i < gameSquares.length - 1; i++) {
            for (int j = 1; j < gameSquares[i].length - 1; j++) {
                if (((i + j) & 0x1) != 0) {
                    gameSquares[i][j] = 0;
                }
            }
        }

        // initialize the squares
        for (int i = 1; i < gameSquares.length - 1; i += 2) {
            for (int j = 1; j < gameSquares[i].length - 1; j += 2) {
                gameSquares[i][j] = 3;
            }
        }

        Vector possibleSquares = new Vector(gameSquares.length * gameSquares[0].length);
        int[] startSquare = new int[2];
        startSquare[0] = getRandomInt(gameSquares.length / 2) * 2 + 1;
        startSquare[1] = getRandomInt(gameSquares[0].length / 2) * 2 + 1;
        gameSquares[startSquare[0]][startSquare[1]] = 2;
        possibleSquares.addElement(startSquare);

        while (possibleSquares.size() > 0) {
            int chosenIndex = getRandomInt(possibleSquares.size());
            int[] chosenSquare = (int[])possibleSquares.elementAt(chosenIndex);

            gameSquares[chosenSquare[0]][chosenSquare[1]] = 1;
            possibleSquares.removeElementAt(chosenIndex);
            link(chosenSquare, possibleSquares);
        }

        possibleSquares = null;
        System.gc();
    }

    /**
     * A part of buildMaze.
     * @param chosenSquare
     * @param possibleSquares
     */
    private void link(int[] chosenSquare, Vector possibleSquares) {
        int linkCount = 0;
        int i = chosenSquare[0];
        int j = chosenSquare[1];
        int[] links = new int[8];
        
        if (i >= 3) {
            if (gameSquares[i - 2][j] == 1) {
                links[2 * linkCount] = i - 1;
                links[2 * linkCount + 1] = j;
                linkCount++;
            } else if (gameSquares[i - 2][j] == 3) {
                gameSquares[i - 2][j] = 2;
                
                int[] newSquare = new int[2];
                newSquare[0] = i - 2;
                newSquare[1] = j;
                possibleSquares.addElement(newSquare);
            }
        }
        
        if (j + 3 <= gameSquares[i].length) {
            if (gameSquares[i][j + 2] == 3) {
                gameSquares[i][j + 2] = 2;
                
                int[] newSquare = new int[2];
                newSquare[0] = i;
                newSquare[1] = j + 2;
                possibleSquares.addElement(newSquare);
            } else if (gameSquares[i][j + 2] == 1) {
                links[2 * linkCount] = i;
                links[2 * linkCount + 1] = j + 1;
                linkCount++;
            }
        }

        if (j >= 3) {
            if (gameSquares[i][j - 2] == 3) {
                gameSquares[i][j - 2] = 2;
                
                int[] newSquare = new int[2];
                newSquare[0] = i;
                newSquare[1] = j - 2;
                possibleSquares.addElement(newSquare);
            } else if (gameSquares[i][j - 2] == 1) {
                links[2 * linkCount] = i;
                links[2 * linkCount + 1] = j - 1;
                linkCount++;
            }
        }

        if (i + 3 <= gameSquares.length) {
            if (gameSquares[i + 2][j] == 3) {
                gameSquares[i + 2][j] = 2;
                
                int[] newSquare = new int[2];
                newSquare[0] = i + 2;
                newSquare[1] = j;
                possibleSquares.addElement(newSquare);
            } else if (gameSquares[i + 2][j] == 1) {
                links[2 * linkCount] = i + 1;
                links[2 * linkCount + 1] = j;
                linkCount++;
            }
        }
        
        if (linkCount > 0) {
            int linkChoice = getRandomInt(linkCount);
            int linkX = links[2 * linkChoice];
            int linkY = links[2 * linkChoice + 1];
            gameSquares[linkX][linkY] = 1;
            int[] removeSquare = new int[2];
            removeSquare[0] = linkX;
            removeSquare[1] = linkY;
            possibleSquares.removeElement(removeSquare);
        }
    }

    /**
     * Random value getter.
     * @param upLimit the upper bound for the random number
     * @return a random non-negative integer
     */
    public int getRandomInt(int upLimit) {
        int retVal = _random.nextInt() % upLimit;
        if (retVal < 0) {
            retVal += upLimit;
        }
        
        return retVal;
    }
}
