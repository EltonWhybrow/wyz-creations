<?php
// Define the group names
$group_names = array('number_block_1', 'number_block_2', 'number_block_3', 'number_block_4');
?>

<div class="section numbers-block hidden md:block">
    <div class="px-[10vw]">
        <div class="flex flex-col lg:flex-row justify-center align-middle my-4">
            <?php
            foreach ($group_names as $group_name):
                // Get all fields from the group
                $group_data = get_field($group_name);

                if ($group_data):

                    $stats_number = $group_data['statnumber'] ?? '';
                    $duration = $group_data['duration'] ?? '';
                    $preffix = $group_data['preffix'] ?? '';
                    $suffix = $group_data['suffix'] ?? '';
                    $stat_info = $group_data['stat_info'] ?? '';


            ?>
                    <div class="number-block flex flex-col flex-grow justify-between items-center md:my-4 p-5">
                        <div class="w-full text-center min-w-[220px]">
                            <h3 class="text-[32px]! my-5 font-semibold mb-2.5!">
                                <span class="counter"
                                    data-target="<?php echo esc_attr($stats_number); ?>"
                                    data-prefix="<?php echo esc_attr($preffix); ?>"
                                    data-separator=","
                                    data-delay="250"
                                    data-duration="<?php echo esc_attr($duration); ?>"
                                    data-suffix="<?php echo esc_attr($suffix); ?>">0</span>
                            </h3>
                        </div>

                        <p class="text-center text-xl">
                            <?php echo esc_html($stat_info); ?>
                        </p>
                    </div>
            <?php
                endif;
            endforeach;
            ?>
        </div>
    </div>
</div>