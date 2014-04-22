package pl.dominikw;

import java.io.*;
import java.net.*;

import javax.swing.JEditorPane;
import javax.swing.event.HyperlinkEvent;
import javax.swing.event.HyperlinkListener;

import java.awt.Desktop;

/**
 * Hyperlinks listener for JEditorPane UI component.
 * 
 * @author Dominik Wlazlowski | http://www.directcode.eu/
 * @version 1.0
 */
public class UIHyperlinkListener implements HyperlinkListener {
    
    JEditorPane editorPane;
    
    /**
     * Listener.
     * 
     * @param editorPane 
     */
    public UIHyperlinkListener(JEditorPane editorPane) {
        this.editorPane = editorPane;
    }
    
    /**
     * Event handler.
     * 
     * @param hyperlinkEvent 
     */
    @Override public void hyperlinkUpdate(HyperlinkEvent hyperlinkEvent) {
        HyperlinkEvent.EventType type = hyperlinkEvent.getEventType();
        final URL url = hyperlinkEvent.getURL();
        
        if (type == HyperlinkEvent.EventType.ENTERED) {
            // System.out.println("URL: " + url);
        } else if (type == HyperlinkEvent.EventType.ACTIVATED) {
            try {
                urlNavigate(url.toURI());
            } catch (Exception e) { System.out.println(e.getMessage()); }
        }
    }
    
    /**
     * Navigate to url.
     * 
     * @throws IOException
     * @throws URISyntaxException
     */
    public void urlNavigate(URI foundUri) throws IOException, URISyntaxException {
        Desktop.getDesktop().browse(foundUri);
    }
    
}
