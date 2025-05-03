import { __ } from "@wordpress/i18n";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { PanelBody, TextControl, ToggleControl } from "@wordpress/components";
import Video from "./components/Video";
import VidPressRadioGroup from "../../components/VidPressRadioGroup";

import "./editor.scss";

export default function Edit({ attributes, setAttributes }) {
  const { video_provider, video_url, autoplay, loop, controls, ratio } = attributes;
  const blockProps = useBlockProps({ className: 'vidpress' });

  const videoProviders = {
    youtube: 'YouTube',
    vimeo: 'Vimeo',
  };

  const allRatios = {
    "ratio-16-9": "16:9",
    "ratio-4-3": "4:3",
    "ratio-9-16": "9:16",
    "ratio-3-4": "3:4",
    "ratio-1-1": "1:1",
  };

  return (
    <>
      <InspectorControls>
        <PanelBody title={__("VidPress Video", "vp")} initialOpen={true}>
          <TextControl
            label={__("Enter Video URL", "vp")}
            value={video_url || ""}
            placeholder={__("Paste video URL", "vp")}
            onChange={(value) => setAttributes({ video_url: value })}
          />
        </PanelBody>
        <PanelBody title={__("Video Settings", "vp")} initialOpen={true}>
          <VidPressRadioGroup
            label={__("Aspect Ratio", "vp")}
            options={allRatios}
            selected={ratio}
            name="ratio"
            updateOption={setAttributes}
          />
          <ToggleControl
            label={__("Controls", "vp")}
            checked={controls}
            onChange={(value) => setAttributes({ controls: value })}
          />
          <ToggleControl
            label={__("Autoplay Video", "vp")}
            checked={autoplay}
            onChange={(value) => setAttributes({ autoplay: value })}
          />
          <ToggleControl
            label={__("Loop Video", "vp")}
            checked={loop}
            onChange={(value) => setAttributes({ loop: value })}
          />
        </PanelBody>
      </InspectorControls>

      <section {...blockProps}>
        <div className="w-video-block">
          { <Video data={attributes} setAttributes={setAttributes} /> }
        </div>
      </section>
    </>
  );
}
