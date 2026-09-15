<?php
namespace Rehike\Model\Comments;
use \Rehike\Model\Common\MButton;

class MCommentVoteButton extends MButton
{
    /**
     * @inheritdoc
     */
    public array $class = [
        "comment-action-buttons-renderer-thumb",
        "sprite-comment-actions"
    ];

    /**
     * @inheritdoc
     */
    public array $attributes = [
        "url" => "/comment_service_ajax?action_perform_comment_action=1"
    ];
 
    public string $type;
    public string $action;
    public string $a11yLabel;
	public bool $checked;

    public function __construct($data)
    {
        $this->a11yLabel = $data["a11yLabel"] ?? "";
        $this->icon = (object) [];

        $this->class[] = "sprite-" . $data["type"];
        $this->class[] = "i-a-v-sprite-" . $data["type"];

        $this->attributes["action-type"] = $data["type"] ?? "";
        $this->attributes["action"] = $data["action"] ?? "";
        $this->accessibility = (object) [
            "accessibilityData" => (object) [
                "checked" => $data["checked"] ? "true" : "false"
            ]
        ];
		$this->checked = $data["checked"];
        $this->isDisabled = $data["isDisabled"] ?? false;
    }

    public static function fromData($data)
    {
        $iconType = $data->defaultIcon->iconType ?? "";
        $type = strtolower($iconType) ?: "like";
        $checked = $data->isToggled ?? false;
        $action = $checked
            ? ($data->toggledServiceEndpoint->performCommentActionEndpoint->action ?? null)
            : ($data->defaultServiceEndpoint->performCommentActionEndpoint->action ?? null);
        $action ??= "";
        $a11yLabel = $checked ? ($data->toggledTooltip ?? null) : ($data->defaultTooltip ?? null);

        return new self([
            "type" => $type,
            "action" => $action,
            "a11yLabel" => $a11yLabel,
            "checked" => $checked,
            "isDisabled" => $data->isDisabled ?? false
        ]);
    }
}