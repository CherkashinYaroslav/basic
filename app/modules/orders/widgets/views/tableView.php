<?php

foreach ($provider->getModels() as $model) {
    $status = $model->getStatus();
    $mode = $model->getMode();
    $userName = $model->getUserFullName();
    $serviceName = $model->getServiceNane();
    $serviceId = $model->getServiceId();
    $date = $model->getFullDatetime();
    echo "<tr>
                      <td>$model->id</td>
                      <td>$userName</td>
                      <td class=\"link\">$model->link</td>
                      <td>$model->quantity</td>
                      <td class=\"service\">
                        <span class=\"label-id\">$serviceId</span>$serviceName
                      </td>
                      <td>$status </td>
                      <td>$mode</td>
                      <td><span class=\"nowrap\">$date</span></td>
                    </tr>
                    ";
}
