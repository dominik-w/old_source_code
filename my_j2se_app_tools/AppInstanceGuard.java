package pl.dominikw;

import java.io.File;
import java.io.RandomAccessFile;
import java.nio.channels.FileLock;

/**
 * AppInstanceGurad - preventing from running more than one instance of the application.
 *
 * @author Dominik Wlazlowski | http://www.directcode.eu/
 * @version 1.1
 */
public class AppInstanceGuard
{
    /**
     * Lock instance - core method.
     *
     * @param lockFile Temporary file handler
     * @return boolean
     */
    public static boolean lockInstance(final String lockFile) {
        
        String userHomeDir = System.getProperty("user.home");
        String fileSeparator = System.getProperty("file.separator");
        String guardFile = userHomeDir + fileSeparator + lockFile;
        
        try {
            final File file = new File(guardFile);
            final RandomAccessFile randomAccessFile = new RandomAccessFile(file, "rw");
            final FileLock fileLock = randomAccessFile.getChannel().tryLock();
            if (fileLock != null) {
                Runtime.getRuntime().addShutdownHook(new Thread() {
                    public void run() {
                        try {
                            fileLock.release();
                            randomAccessFile.close();
                            file.delete();
                        } catch (Exception e) { System.out.println(e.getMessage()); }
                    }
                });

                return true;
            }
        } catch (Exception e) { System.out.println(e.getMessage()); }
        
        return false;
    }
}
