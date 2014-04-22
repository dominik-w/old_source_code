/*
 * PreferencesStorage.java
 * Store preferences using RMS.
 */

package hello;

import javax.microedition.rms.*;

/**
 * Preferences.
 * 
 * @author Dominik Wlazlowski
 */
public class PreferencesStorage {
    
    // name of the datastore
    public static final String STORE = "SizePreferences";

    /**
     * Square size getter.
     */
    public static int getSquareSize() {
        int retVal = 5;
        RecordStore store = null;
        try {
            store = RecordStore.openRecordStore(STORE, false);
            if ((store != null) && (store.getNumRecords() > 0)) {
                byte[] rec = store.getRecord(1);
                retVal = rec[0];
            }
        } catch(Exception e) { }
        finally {
            try {
                store.closeRecordStore();
            } catch(Exception e) { }
        }
        
        return retVal;
    }

    /**
     * Save preferred square size.
     * @param size
     */
    public static void setSquareSize(int size) {
        RecordStore store = null;
        try {
            if (size > 127) {
                size = 127;
            }

            store = RecordStore.openRecordStore(STORE, true);
            byte[] record = new byte[1];
            record[0] = (new Integer(size)).byteValue();
            int numRecords = store.getNumRecords();
            
            if (numRecords > 0) {
                store.setRecord(1, record, 0, 1);
            } else {
                store.addRecord(record, 0, 1);
            }
        } catch(Exception e) { } 
        finally {
            try {
                store.closeRecordStore();
            } catch(Exception e) { }
        }
    }
}
