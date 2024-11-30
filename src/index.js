import './index.scss'
import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon, PanelBody, PanelRow, ColorPicker} from "@wordpress/components"
import {InspectorControls, BlockControls, AlignmentToolbar, useBlockProps} from "@wordpress/block-editor"

import React from 'react'

wp.blocks.registerBlockType('my-block-use-post/blockusepostdata', {
    title: 'Block use post data',
    icon: 'heart',
    category: 'common',
    attributes: {
        postId: {type: 'string'}
    },
    description: '这是添加这个模块的描述，解释这个模块的作用',
    edit: EditComponent,
    save: function(props) {return null},
});

function EditComponent(props) {
    return (
        <div>
            <select onChange={e => props.setAttributes({postId: e.target.value})}>
                <option value="">Select a professor</option>
                <option value="1" selected={props.attributes.postId == 1}>1</option>
                <option value="2" selected={props.attributes.postId == 2}>2</option>
                <option value="3" selected={props.attributes.postId == 3}>3</option>
            </select>
        </div>
    )
}