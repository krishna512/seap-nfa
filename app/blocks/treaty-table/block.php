<?php
$id = '' . $block['id'];
$className = 'comparision-table';

if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

/**
 * =================================================
 * Get acf field values
 * =================================================
 */
$title = (get_field('title')) ?: 'Comparision Table';
$columns = (get_field('define_headers')) ?: '';
$rows = (get_field('define_rows')) ?: '';


/**
 * =================================================
 * HTML output content
 * =================================================
 */
?>

<section id="<?php echo $id; ?>" class="<?php echo esc_attr($className); ?>" class="">
    <div class="title text-center text-n-30 text-base font-semibold mb-[14px]">
        <?php echo $title; ?>
    </div>
    <div class="overflow-x-auto block">
        <table class="comparison-info w-full min-w-[800px]">
            <thead>
                <tr>
                    <?php
                    if ($columns && is_array($columns)) {
                        foreach ($columns as $key => $column) {

                            ?>
                            <th col-num="<?php echo $key + 1; ?>">
                                <?php echo $column['name']; ?>
                            </th>
                            <?php
                        }
                    }
                    ?>
                </tr>

            </thead>
            <tbody class="comparison-info__data">
                <?php
                if ($rows && is_array($rows)) {
                    foreach ($rows as $key => $row) {
                        $each_row_data = ($row['each_row_data']) ?: '';
                        ?>
                        <tr row-num="<?php echo $key + 1; ?>">
                            <?php
                            if ($each_row_data && is_array($each_row_data)) {
                                foreach ($each_row_data as $row_data_key => $row_data) {
                                    if (($row_data_key) === count($columns)) {
                                        break;
                                    }
                                    ?>
                                    <td col-num="<?php echo $row_data_key + 1; ?>">
                                        <span class="state">
                                            <?php
                                            if (strtolower($row_data['state']) === 'allow') {
                                                echo useSVG('allow');
                                            } elseif (strtolower($row_data['state']) === 'block') {
                                                echo useSVG('block');
                                            } elseif (strtolower($row_data['state']) === 'warning') {
                                                echo useSVG('warning');
                                            }
                                            ?>
                                        </span>
                                        <span class="label">
                                            <?php echo $row_data['label']; ?>
                                        </span>
                                    </td>
                                    <?php
                                }
                            }
                            ?>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</section>