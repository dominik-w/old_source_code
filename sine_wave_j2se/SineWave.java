/*
 * Sine wave. Simple Swing demo program.
 */

package javaapps;

/**
 * Demo.
 * 
 * @author Dominik Wlazlowski
 */
import java.awt.*;
import javax.swing.*;

class Sinus extends JPanel {
    static final int _SCALE = 240;
    int cycles;
    int points;
    double[] sines;
    int[] pts;

    Sinus() {
    }

    /**
     * Setter for number of wave cycles.
     * 
     * @param new_cycles
     */
    public void setCycles(int new_cycles) {
        cycles = new_cycles;
        points = _SCALE * cycles * 2;
        sines = new double[points];
        for (int i = 0; i < points; i++) {
            double radians = (Math.PI / _SCALE) * i;
            sines[i] = Math.sin(radians);
        }
        repaint();
    }

    /**
     * Overridden painting method.
     * 
     * @param g
     */
    @Override
    public void paintComponent(Graphics g) {
        super.paintComponent(g);

        int maxWidth = getWidth();
        double h_step = (double) maxWidth / (double) points;
        int maxHeight = getHeight();
        
        pts = new int[points];

        for (int i = 0; i < points; i++)
            pts[i] = (int) (sines[i] * maxHeight / 2 * 0.95 + maxHeight / 2);
        g.setColor(Color.BLUE); // .GREEN

        for (int i = 1; i < points; i++) {
            int x1 = (int) ((i - 1) * h_step);
            int x2 = (int) (i * h_step);
            int y1 = pts[i - 1];
            int y2 = pts[i];
            g.drawLine(x1, y1, x2, y2);
        }
    }
}

public class SineWave {
    public static void main(String[] args) {
        JFrame frame = new JFrame("Sine Wave demo program");
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.setSize(520, 240);
        Sinus sines = new Sinus();
        sines.setCycles(7);
        frame.getContentPane().add(sines);
        frame.setVisible(true);
    }
}
