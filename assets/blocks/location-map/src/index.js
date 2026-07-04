import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import Edit from './edit';

registerBlockType( 'webuildsites/location-map', {
	edit: Edit,
	save() {
		return null;
	},
} );