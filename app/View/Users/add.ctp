<div class="users form" ng-controller="CreateUserViewModel">
    <?php echo $this->Form->create('User'); ?>
    <fieldset class="form">
        <legend><?php echo __('Add User'); ?></legend>
        <?php
           echo $this->Form->input('username');
           echo $this->Form->input('password');
        ?>

        <!-- drop down -->
        <select name="data[User][group_id]">
            <option ng-repeat="group in groups" label="{{group.Group.name}}">{{group.Group.id}}</option>
        </select>

        <!-- button -->
        <?php echo $this->Form->end(__('Submit')); ?>
    </fieldset>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>

    <!-- list -->
    <ul>
        <li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
    </ul>
</div>
<script type="text/javascript">
    function CreateUserViewModel($scope, $resource) {
        $resource('../Groups/getAll.json').get(function(result) {
            $scope.groups = result.groups;
        });
    }
</script>
