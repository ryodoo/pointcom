<div class="questions form">
<?php echo $this->Form->create('Question');?>
    <fieldset>
        <legend><?php echo __('Edit Question'); ?></legend>
        <?php
                echo $this->Form->input('id');
		echo $this->Form->input('questionnaire_id',array('label'=>"Questionnaire"));
		echo $this->Form->input('question',array('label'=>"Description"));
	?>
        <div class="input select">
            <label for="QuestionQuestionnaireId">Type</label>
            <select name="data[Question][type]" id="QuestionQuestionnaireId">
                <option value="case">Repense multiple</option>
                <option value="radio">Repense Unique</option>
            </select>
        </div>
    </fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

