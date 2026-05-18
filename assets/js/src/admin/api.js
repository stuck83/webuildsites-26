const apiRoot = `${window.location.origin}/wp-json/my-theme/v1/settings`;

export const updateSettings = (settings) => {
	const nonceToken =
		window.wprigAcceleratorThemeSettings?.nonce ||
		window.wprigAcceleratorThemeSettings?.nonce ||
		"";

	return fetch(apiRoot, {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
			"X-WP-Nonce": nonceToken,
		},
		body: JSON.stringify({ settings }),
	}).then((response) => response.json());
};
