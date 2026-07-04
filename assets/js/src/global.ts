/**
 * File global.ts.
 *
 * Handles global TypeScript for your theme.
 */

// Extend the Window interface properly
declare global {
	interface Window {
		mobileBreakpoint: number;
		isWidthMobile: () => boolean;
		wpRig?: Element | null;
	}
}

// This export makes the file a module and allows declare global to work
export {};

window.mobileBreakpoint = 55;

window.isWidthMobile = (): boolean => {
	const fontSizeStr = getComputedStyle(
		document.documentElement
	).fontSize.slice( 0, -2 );
	const fontSize = parseFloat( fontSizeStr );
	const emValue = window.innerWidth / fontSize;
	window.wpRig = document.querySelector( '.wp-rig' );
	return emValue <= window.mobileBreakpoint;
};

/* Vanilla JavaScript Scroll Progress - Article Targeted */
window.addEventListener('scroll', () => {
    const progressBar = document.getElementById('blog-progress-bar');
    // Using the 'article' tag which contains your post content
    const article = document.querySelector('article'); 
    
    if (progressBar && article) {
        const articleRect = article.getBoundingClientRect();
        const articleHeight = article.offsetHeight;
        
        // Calculate how much of the article has scrolled past the top of the viewport
        // We subtract the window height to ensure it hits 100% when the bottom of the article is visible
        const windowHeight = window.innerHeight;
        const progressRaw = (Math.abs(articleRect.top) / (articleHeight - windowHeight)) * 100;
        
        // Constrain between 0 and 100
        const scrolled = Math.max(0, Math.min(100, progressRaw));
        
        // Hide bar if we haven't reached the article yet
        if (articleRect.top > 0) {
            progressBar.style.width = "0%";
        } else {
            progressBar.style.width = scrolled + "%";
        }
    }
});