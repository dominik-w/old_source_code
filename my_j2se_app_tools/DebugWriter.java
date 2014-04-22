package pl.dominikw;

import java.io.*;

import java.util.Calendar;
import java.text.SimpleDateFormat;

/**
 * Debug writer implementation - basic.
 * 
 * @author Dominik Wlazlowski | http://www.directcode.eu/
 * @version 1.0
 */
public class DebugWriter {
    
    public static final String DBG_FILE = System.getProperty("user.home") 
            + System.getProperty("file.separator") + "debug_ft.txt";
    
    public static final String DATE_FORMAT_NOW = "yyyy-MM-dd HH:mm:ss";
    
    public DebugWriter() {
    }

    /**
     * Current date and time.
     * @return Date-time string.
     */
    public static String now() {
        Calendar cal = Calendar.getInstance();
        SimpleDateFormat sdf = new SimpleDateFormat(DATE_FORMAT_NOW);
        return sdf.format(cal.getTime());
    }
    
    /**
     * Write debug data to file.
     * @param data 
     */
    public void write(String data, Exception dbg_e) {
        
        try {
            FileWriter fstream = new FileWriter(DBG_FILE, true);
            BufferedWriter out = new BufferedWriter(fstream);
            
            out.write("\n-----\n");
            out.write(now() + ": ");
            out.write(data);
            
            out.write(dbg_e.getMessage());
            
            out.write("\nStack trace:\n");
            StringWriter sw = new StringWriter();
            PrintWriter pw = new PrintWriter(sw);
            dbg_e.printStackTrace(pw);
            out.write(sw.toString());
            
            out.write("\n");
            
            out.close();
        } catch (Exception e) {
            System.err.println("IO error: " + e.getMessage());
        }
    }
    
}
