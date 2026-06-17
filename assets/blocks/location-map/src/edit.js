import { __ } from "@wordpress/i18n";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { PanelBody, TextControl, RangeControl } from "@wordpress/components";

export default function Edit({ attributes, setAttributes }) {
	const { address, zoom } = attributes;
	const blockProps = useBlockProps({
		className: "webuildsites-map-container alignwide",
	});

	const mapUrl = `https://maps.google.com/maps?q=${encodeURIComponent(
		address,
	)}&t=&z=${zoom}&ie=UTF8&iwloc=&output=embed`;

	return (
		<div {...blockProps}>
			<InspectorControls>
				<PanelBody
					title={__("Map Settings", "webuildsites")}
					initialOpen={true}
				>
					<TextControl
						label={__("Map Address", "webuildsites")}
						value={address}
						onChange={(value) => setAttributes({ address: value })}
					/>
					<RangeControl
						label={__("Zoom Level", "webuildsites")}
						value={zoom}
						onChange={(value) => setAttributes({ zoom: value })}
						min={1}
						max={18}
					/>
				</PanelBody>
			</InspectorControls>

			{/* Live Editor Preview Frame */}
			<div
				class="map-inner-frame"
				style={{
					position: "relative",
					width: "100%",
					height: "450px",
					overflow: "hidden",
					borderRadius: "8px",
					background: "#eee",
				}}
			>
				<iframe
					width="100%"
					height="100%"
					src={mapUrl}
					frameborder="0"
					scrolling="no"
					style={{
						border: 0,
						pointerEvents: "none",
						filter: "grayscale(10%) contrast(110%)",
					}}
				/>
			</div>
		</div>
	);
}
