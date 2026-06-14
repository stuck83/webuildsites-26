// Use WP globals
// eslint-disable-next-line @typescript-eslint/no-unsafe-member-access
const { registerBlockType } = (wp).blocks;
// eslint-disable-next-line @typescript-eslint/no-unsafe-member-access
const { __ } = (wp).i18n;
import Edit from './edit';

registerBlockType('accelerator-production/location-map', {
	apiVersion: 2,
	title: __('Location Map', 'wp-rig'),
	edit: Edit,
	save() {
		return null;
	},
});
